<?php

namespace App\Http\Controllers;

use App\Http\Resources\MyProjectItemResource;
use App\Http\Resources\PaymentDetailsResource;
use App\Http\Resources\PaymentItemResource;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeController extends Controller
{

    public function getMyDashboardData()
    {
        $user = Auth::user();
        $payments = Payment::where('user_id', $user->id)->orderBy('id', 'desc')->get();
        $projects = Payment::where('user_id', $user->id)->select('project_id')->distinct()->get();
        return response([
            "statistics" => [
                "total_given_amount" => $payments->sum('given_amount'),
                "total_projects" => $projects->count(),
                "total_transactions" => $payments->count()
            ],
            'payments' => PaymentItemResource::collection($payments),
            'projects' => MyProjectItemResource::collection($projects)
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
