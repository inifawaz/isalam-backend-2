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
        return [
            "id" => $this->id,
            "merchant_order_id" => $this->merchant_order_id,
            "created_at" => $this->created_at->format('d F Y H:i'),
            "project_id" => $this->project->id,
            "name" => $this->project->name,
            "total_amount" => $this->total_amount,
            "payment_name" => $this->payment_name,
            "payment_image_url" => $this->payment_image_url,
            "va_number" => $this->va_number,
            "expiry_period" => $this->expiry_period,
            "status" => OnaizaDuitku::checkPaymentStatus($this->merchant_order_id)
        ];
    }
}
