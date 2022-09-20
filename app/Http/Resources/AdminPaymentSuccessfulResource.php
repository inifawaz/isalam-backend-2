<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminPaymentSuccessfulResource extends JsonResource
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
            "name" => $this->user->full_name,
            "given_amount" => $this->given_amount,
            "paid_at" => $this->paid_at ? $this->paid_at->format('d/m/Y H:i') : '',
            "payment_name" => $this->payment_name
        ];
    }
}
