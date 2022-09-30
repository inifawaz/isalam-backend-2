<?php

namespace App\Http\Controllers;

use App\Http\Resources\MyProjectItemResource;
use App\Http\Resources\PaymentDetailsResource;
use App\Http\Resources\PaymentItemResource;
use App\Http\Resources\UserResource;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeController extends Controller
{

    public function getMyDashboardData()
    {
        $user = Auth::user();
        $payments = $user->payments;
        $projects = Payment::where('user_id', $user->id)->where('status_code', '00')->select('project_id')->distinct()->get();
        return response([
            "statistics" => [
                "total_given_amount" => $payments->where('status_code', '00')->sum('given_amount'),
                "total_projects" => $projects->count(),
                "total_transactions" => $payments->where('status_code', '00')->count()
            ],
            'payments' => PaymentItemResource::collection($payments),

            'projects' => MyProjectItemResource::collection($projects),
            "profile" => new UserResource($user)
        ]);
    }


    public function getMyPaymentDetails($id)
    {
        $user = Auth::user();
        $payment = Payment::where('merchant_order_id', $id)->first();
        return response([
            'payment' => new PaymentDetailsResource($payment)
        ]);
    }
}
