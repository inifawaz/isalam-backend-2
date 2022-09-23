<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleDetailsResource extends JsonResource
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
            'topic' => $this->topic->name,
            "featured_image_url" => $this->featured_image_url,
            "content" => $this->content,
            'created_at' => $this->created_at->format('d F Y'),
            "is_shown" => $this->is_shown
        ];
    }
}
