<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BackerItemResource extends JsonResource
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
            "avatar_url" => $this->user->avatar_url,
            "name" => $this->user->full_name,
            "given_amount" => $this->given_amount,
            "paid_at" => Carbon::parse($this->created_at)->diffForHumans()
        ];
    }
}
