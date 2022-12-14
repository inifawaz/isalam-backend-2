<?php

namespace App\Http\Resources;

use App\Helpers\OnaizaDuitku;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $return =  [
            "id" => $this->id,
            'user_id' => $this->user_id,
            'user_name' => $this->user->full_name,
            'user_email' => $this->user->email,
            "merchant_order_id" => $this->merchant_order_id,
            "created_at" => $this->created_at->format('d F Y H:i'),
            "project_id" => $this->project->id,
            "name" => $this->project->name,
            "total_amount" => $this->total_amount,
            "payment_name" => $this->payment_name,
            "payment_image_url" => $this->payment_image_url,
            "va_number" => $this->va_number,
            "expiry_period" => $this->expiry_period,
            "is_paid" => $this->is_paid,
            'status_code' => $this->status_code,
            "signature" => $this->signature,
            'merchant_code' => $this->merchant_code
        ];



        $status_code = $this->status_code;
        if ($status_code == null) {
            $return['status'] = OnaizaDuitku::checkPaymentStatus($this->merchant_order_id);
        }

        if ($status_code == '00') {
            $return['paid_at'] = $this->paid_at->format('d F Y H:i');
        }

        return $return;
    }
}
