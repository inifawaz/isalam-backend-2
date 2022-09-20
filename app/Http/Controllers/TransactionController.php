<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = Payment::where('reference', $request->reference)->first();

        $transaction = Transaction::create([
            "user_id" => Auth::user()->id,
            "project_id" => $order->project_id,
            "given_amount" => $order->given_amount,
            "maintenance_fee" => $order->maintenance_fee,
            "payment_fee" => $order->payment_fee,
            "total_amount" => $request->amount,
            "merchant_code" => $request->merchantCode,
            "merchant_order_id" => $request->merchantOrderId,
            "reference" => $request->reference,
            "payment_method" => $order->paymentMethod,
            "payment_name" => $order->payment_name,
            "payment_image_url" => $order->payment_image_url,
            "payment_url" => $order->payment_url,
            "va_number" => $order->va_number,
            "qr_string" => $order->qr_string ?? null,
            "expiry_period" => $order->expiry_period,
            "result_code" => $request->resultCode

        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
