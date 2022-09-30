<?php

namespace App\Http\Controllers;

use App\Helpers\OnaizaDuitku;
use App\Http\Resources\PaymentDetailsResource;
use App\Http\Resources\PaymentItemResource;
use App\Models\Callback;
use App\Models\Payment;
use App\Models\Project;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    private $api_key;
    private $merchant_code;
    private $callback_url;
    private $return_url;
    private $expiry_period;

    public function __construct()
    {
        $this->api_key = config('app.duitku_api_key');
        $this->merchant_code = config('app.duitku_merchant_code');
        $this->callback_url = config('app.duitku_callback_url');
        $this->return_url = config('app.duitku_return_url');
        $this->expiry_period = 60 * 24;
    }
    public function getPaymentMethods(Request $request)
    {
        $project = Project::findOrFail($request->project_id);
        $paymentMethods = OnaizaDuitku::getPaymentMethods($request->amount, $request->project_id);
        return response([
            'maintenance_fee' => $project->maintenance_fee,
            'payment_methods' => $paymentMethods->paymentFee
        ]);
    }

    public function getMyPayments()
    {
        $user = Auth::user();
        $payments = $user->payments;
        return response([
            'payments' => PaymentItemResource::collection($payments)
        ]);
    }

    public function callback(Request $request)
    {
        $apiKey = $this->api_key; // API key anda
        $merchantCode = $request->merchantCode;
        $amount = $request->amount;
        $merchantOrderId = $request->merchantOrderId;
        $productDetail = $request->productDetail;
        $additionalParam = $request->additionalParam;
        $paymentMethod = $request->paymentCode;
        $resultCode = $request->resultCode;
        $merchantUserId = $request->merchantUserId;
        $reference = $request->reference;
        $signature = $request->signature;
        $spUserHash = $request->spUserHash;
        //log callback untuk debug
        // file_put_contents('callback.txt', "* Callback *\r\n", FILE_APPEND | LOCK_EX);

        if (!empty($merchantCode) && !empty($amount) && !empty($merchantOrderId) && !empty($signature)) {
            $params = $merchantCode . $amount . $merchantOrderId . $apiKey;
            $calcSignature = md5($params);
            // dd($calcSignature);


            if ($signature == $calcSignature) {
                //Callback tervalidasi
                //Silahkan rubah status transaksi anda disini
                // file_put_contents('callback.txt', "* Success *\r\n\r\n", FILE_APPEND | LOCK_EX);
                $callback = new Callback();
                $callback->merchant_code = $merchantCode;
                $callback->amount = $amount;
                $callback->merchant_order_id = $merchantOrderId;
                $callback->product_detail = $productDetail;
                $callback->additional_param = $additionalParam;
                $callback->payment_method = $paymentMethod;
                $callback->result_code = $resultCode;
                $callback->merchant_user_id = $merchantUserId;
                $callback->reference = $reference;
                $callback->signature = $signature;
                $callback->sp_user_hash = $spUserHash;
                $callback->save();

                if ($resultCode == 00) {
                    $payment = Payment::where('reference', $reference)->first();
                    $payment->is_paid = true;
                    $payment->paid_at = now()->format('Y-m-d H:i:s');
                    $payment->status_code = $resultCode;
                    $payment->save();

                    return response([
                        'message' => 'berhasil',
                        'payment' => $payment
                    ]);
                }
                if ($resultCode == 01) {
                    $payment = Payment::where('reference', $reference)->first();

                    $payment->status_code = $resultCode;

                    $payment->save();

                    return response([
                        'message' => 'gagal',
                        'payment' => $payment
                    ]);
                }
            } else {
                // file_put_contents('callback.txt', "* Bad Signature *\r\n\r\n", FILE_APPEND | LOCK_EX);
                throw new Exception('Bad Signature');
            }
        } else {
            // file_put_contents('callback.txt', "* Bad Parameter *\r\n\r\n", FILE_APPEND | LOCK_EX);
            throw new Exception('Bad Parameter');
        }
    }



    public function getPaymentDetails(Payment $payment)
    {
        return response([
            'payment' => new PaymentDetailsResource($payment)
        ]);
    }

    public function store(Request $request)
    {

        $project = Project::find($request->project_id);
        if ($project == null) {
            return response([
                'message' => 'program wakaf tidak ditemukan'
            ], 404);
        }

        // $payments = Payment::where('project_id', '=', $request->project_id)->get();
        // $amount_collected = $payments->sum('project_amount_given') ?? 0;

        // if (($amount_collected + $request->project_amount_given) > $project->target_amount) {
        //     $selisih = $project->target_amount - $amount_collected;
        //     return response([
        //         'status' => 'error',
        //         'message' => 'nominal wakaf yang anda berikan tidak boleh melebihi sisa target nominal wakaf yang telah ditentukan'

        //     ], 500);
        // }
        //
        $datetime = date('Y-m-d H:i:s');
        $signature = hash('sha256', $this->merchant_code . $request->given_amount . $datetime . $this->api_key);
        $paymentMethod = $request->paymentMethod;

        $params = array(
            'merchantcode' => $this->merchant_code,
            'amount' => $request->given_amount,
            'datetime' => $datetime,
            'signature' => $signature
        );

        $params_string = json_encode($params);

        $url = 'https://sandbox.duitku.com/webapi/api/merchant/paymentmethod/getpaymentmethod';

        $response =  Http::withHeaders([
            'Content-Type' => 'application/json',
            'Content-Length: ' . strlen($params_string)
        ])->post($url, $params);


        $a = array_filter($response['paymentFee'], function ($item) {
            global $request;
            return $item['paymentMethod'] == $request->paymentMethod;
        });
        $paymentMethodSelected = reset($a);



        $merchantCode = $this->merchant_code;


        // Generate Merchant Oder Id
        // $now = Carbon::now('Asia/Jakarta');
        // $project_id_code = str_pad($project->id, 3, "8", STR_PAD_LEFT);
        // $year_code = $now->format('y');
        // $month_code = $now->format('m');
        // $day_code = $now->format('d');
        // $hour_code = $now->format('h');
        // $minute_code = $now->format('i');
        // $second_code = $now->format('s');
        //
        $merchantOrderId = OnaizaDuitku::generateOrderId($request->project_id);

        $productDetails = $project->name;
        $email = Auth::user()->email;

        $merchantUserInfo = Auth::user()->id;
        $customerVaName = Auth::user()->full_name;
        $phoneNumber = Auth::user()->phone_number;

        $itemDetails = [
            [
                "name" => 'Nominal Wakaf Yang Diberikan',
                "quantity" => 1,
                'price' => $request->given_amount
            ],
            [
                "name" => 'Biaya Pemeliharaan Sistem',
                "quantity" => 1,
                'price' => $project->maintenance_fee
            ],
        ];
        $paymentAmount = $request->given_amount + $project->maintenance_fee;

        $returnUrl = $this->return_url;
        $callbackUrl = $this->callback_url;
        $signatureA = md5($this->merchant_code . $merchantOrderId . $paymentAmount . $this->api_key);
        $expiryPeriod = $this->expiry_period;

        $params = array(
            'merchantCode' => $merchantCode,
            'paymentAmount' => $paymentAmount,
            'paymentMethod' => $paymentMethod,
            'merchantOrderId' => $merchantOrderId,
            'productDetails' => $productDetails,
            'merchantUserInfo' => $merchantUserInfo,
            'customerVaName' => $customerVaName,
            'email' => $email,
            'phoneNumber' => $phoneNumber,
            'itemDetails' => $itemDetails,
            'callbackUrl' => $callbackUrl,
            'returnUrl' => $returnUrl,
            'signature' => $signatureA,
            'expiryPeriod' => $expiryPeriod
        );
        $url = 'https://sandbox.duitku.com/webapi/api/merchant/v2/inquiry';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            //            'Content-Length: ' . strlen($params)
        ])->post($url, $params);

        if ($response->successful() && $response['statusCode'] == "00" && $response['statusMessage'] === "SUCCESS") {
            $result = json_decode($response, true);
            $payment = Payment::create(
                [
                    "user_id" => Auth::user()->id,
                    "project_id" => $project->id,
                    "on_behalf" => $request->on_behalf,
                    'is_anonim' => $request->is_anonim,
                    "given_amount" => $request->given_amount,
                    "maintenance_fee" => $project->maintenance_fee,
                    "payment_fee" => $paymentMethodSelected['totalFee'],
                    "total_amount" => $result['amount'],
                    "merchant_code" => $merchantCode,
                    "merchant_order_id" => $merchantOrderId,
                    "reference" => $result['reference'],
                    "payment_method" => $paymentMethod,
                    "payment_name" => $paymentMethodSelected['paymentName'],
                    "payment_image_url" => $paymentMethodSelected['paymentImage'],
                    "payment_url" => $result['paymentUrl'],
                    "va_number" => $result['vaNumber'] ?? null,
                    "qr_string" => $result['qrString'] ?? null,
                    "expiry_period" => $this->expiry_period,
                    "signature" => $signature,
                    'callback_url' => $callbackUrl,
                    'return_url' => $returnUrl,
                    'product_details' => $productDetails

                ]
            );

            return response([
                'result' => $result,
                'payment' => $payment
            ], 201);
        } else {
            $result = json_decode($response);
            // return "Server Error: " . $result->Message;
            return response([
                'status' => 'errors',
                'message_from_server' => $result->Message,
                "message" => 'tidak dapat membuat pembayaran'
            ], 500);
        }
        // return $result;
    }
}
