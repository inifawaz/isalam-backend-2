<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $collected_amount = $this->paymentsSuccess->sum('given_amount') ?? 0;
        $return = [
            "id" => $this->id,
            "featured_image_url" => $this->featured_image_url,
            "category" => $this->category->name,
            "location" => $this->location,
            "name" => $this->name,
            "collected_amount" => $collected_amount,
            "is_target" => $this->is_target,
            "is_limited_time" => $this->is_limited_time,
            "is_ended" => $this->is_ended,
            'total_backers' => $this->paymentsSuccess->count(),
            "is_shown" => $this->is_shown,
            "is_ended" => $this->is_ended
        ];
        if ($this->is_target) {
            $return['target_amount'] = $this->target_amount;
            $return['percent_collected_amount'] = floor($collected_amount / $this->target_amount * 100);
        }
        if ($this->is_limited_time) {
            $return['start_date'] = $this->start_date;
            $return['end_date'] = $this->end_date;
            $return['days_left'] = now()->diffInDays($this->end_date);
        }
        return $return;
    }
}
