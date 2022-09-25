<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminProjectDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $payments = $this->payments;

        return [
            'id' => $this->id,
            'user_id' =>  $this->user_id,
            "featured_image_url" => $this->featured_image_url,
            "name" => $this->name,
            "category_id" => $this->category_id,
            "description" => $this->description,
            "location" => $this->location,
            "instagram_url" => $this->instagram_url,
            "facebook_url" => $this->facebook_url,
            "twitter_url" => $this->twitter_url,
            "maintenance_fee" => $this->maintenance_fee,
            "is_target" => $this->is_target,
            "target_amount" => $this->target_amount,
            "first_choice_given_amount" => $this->first_choice_given_amount,
            "second_choice_given_amount" => $this->second_choice_given_amount,
            "third_choice_given_amount" => $this->third_choice_given_amount,
            "fourth_choice_given_amount" => $this->fourth_choice_given_amount,
            "is_limited_time" => $this->is_limited_time,
            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
            "is_shown" => $this->is_shown,
            "is_ended" => $this->is_ended,
            "is_favourite" => $this->is_favourite,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
