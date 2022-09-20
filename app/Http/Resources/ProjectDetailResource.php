<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $collected_amount = $this->transactions->sum('given_amount') ?? 0;

        $first_choice_given_amount = $this->first_choice_given_amount;
        $second_choice_given_amount = $this->second_choice_given_amount;
        $third_choice_given_amount = $this->third_choice_given_amount;
        $fourth_choice_given_amount = $this->fourth_choice_given_amount;

        $choice_given_amount = array_filter([$first_choice_given_amount, $second_choice_given_amount, $third_choice_given_amount, $fourth_choice_given_amount], function ($item) {
            return $item > 0;
        });


        $return = [
            "id" => $this->id,
            "featured_image_url" => $this->featured_image_url,
            "category" => $this->category->name,
            "location" => $this->location,
            "name" => $this->name,
            "is_target" => $this->is_target,
            "is_time_limit" => $this->is_time_limit,
            "instagram_url" => $this->instagram_url ?? '',
            "facebook_url" => $this->facebook_url ?? '',
            "twitter_url" => $this->twitter_url ?? '',
            "description" => $this->description,
            "maintenance_fee" => $this->maintenance_fee,
            "is_ended" => $this->is_ended,
            "choice_given_amount" => $choice_given_amount,
            "collected_amount" => $collected_amount
        ];
        if ($this->is_target) {
            $return['target_amount'] = $this->target_amount;
            $return['percent_collected_amount'] = floor($collected_amount / $this->target_amount * 100);
        }
        if ($this->is_time_limit) {
            $return['start_date'] = $this->start_date;
            $return['end_date'] = $this->end_date;
            $return['days_left'] = now()->diffInDays($this->end_date);
        }
        return $return;
    }
}
