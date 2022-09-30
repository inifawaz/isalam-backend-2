<?php

namespace App\Helpers;

use App\Models\Payment;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class Duitku
{
    private $api_key;
    private $merchantCode;
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



    public function generateOrderId($project_id)
    {
        //project_id dalam 3 digit + tahun dalam dua digit (2022 = 01, 2023 = 02) + bulan dalam dua digit (Januari = 01) +tanggal dalam dua digit jam dalam dua digit + menit dalam dua digit + detik dalam dua digit;
        // contoh: 01010829204021
        $now = Carbon::now('Asia/Jakarta');
        $project_id_code = str_pad($project_id, 3, "8", STR_PAD_LEFT);
        $year_code = $now->format('y');
        $month_code = $now->format('m');
        $day_code = $now->format('d');
        $hour_code = $now->format('h');
        $minute_code = $now->format('i');
        $second_code = $now->format('s');

        $order_id = $project_id_code . $second_code . $minute_code . $hour_code . $day_code . $month_code . $year_code;
        if ($this->checkOrderId($order_id)) {
            $this->generateOrderId($project_id);
        }
        return $order_id;
    }
    private function checkOrderId($order_id)
    {
        $check_payment = Payment::where('merchant_order_id', '=', $order_id)->first();
        return $check_payment != null;
    }


    public function getPaymentMethods($amount, $projectId)
    {
        $project = Project::findOrFail($projectId);
        $total = $amount + $project->maintenance_fee;

        $datetime = date('Y-m-d H:i:s');
        $signature = hash('sha256', $this->merchant_code . $total . $datetime . $this->api_key);
        $params = array(
            'merchantcode' => $this->merchant_code,
            'amount' => $total,
            'datetime' => $datetime,
            'signature' => $signature
        );

        $params_string = json_encode($params);

        $url = 'https://sandbox.duitku.com/webapi/api/merchant/paymentmethod/getpaymentmethod';

        $response =  Http::withHeaders([
            'Content-Type' => 'application/json',
            'Content-Length: ' . strlen($params_string)
        ])->post($url, $params);
        return json_decode($response);
    }

    public function checkPaymentStatus($merchantOrderId)
    {
        $merchantCode = $this->merchant_code;
        $apiKey = $this->api_key;


        $signature = md5($merchantCode . $merchantOrderId . $apiKey);

        $params = array(
            'merchantCode' => $merchantCode,
            'merchantOrderId' => $merchantOrderId,
            'signature' => $signature
        );

        $params_string = json_encode($params);
        $url = 'https://sandbox.duitku.com/webapi/api/merchant/transactionStatus';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Content-Length: ' . strlen($params_string)
        ])->post($url, $params);

        if ($response->successful()) {
            $result = json_decode($response, true);
        } else {
            $result = json_decode($response);
            return "Server Error: " . $result->Message;
        }
        return $result;
    }

    public function getMerchantCode()
    {
        return $this->merchant_code;
    }
}
