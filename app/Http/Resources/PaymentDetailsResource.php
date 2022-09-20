<?php

namespace App\Http\Resources;

use App\Helpers\OnaizaDuitku;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "project_id" => $this->project->id,
            "name" => $this->project->name,
            "total_amount" => $this->total_amount,
            "given_amount" => $this->given_amount,
            "maintenance_fee" => $this->maintenance_fee,
            "payment_name" => $this->payment_name,
            "payment_fee" => $this->payment_fee,
            "payment_image_url" => $this->payment_image_url,
            "va_number" => $this->va_number,
            "expiry_period" => $this->expiry_period,
            "created_at" => $this->created_at,
            "status" => OnaizaDuitku::checkPaymentStatus($this->merchant_order_id)
        ];
    }
}
