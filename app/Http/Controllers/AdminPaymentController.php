<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentItemResource;
use App\Models\Payment;
use Illuminate\Http\Request;

class AdminPaymentController extends Controller
{
    public function index()
    {
        return response([
            'payments' =>  PaymentItemResource::collection(Payment::orderBy('id', 'desc')->get())
        ]);
    }
}
