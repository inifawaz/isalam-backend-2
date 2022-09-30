<?php

namespace App\Http\Resources;

use App\Models\Payment;
use App\Models\Project;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class MyProjectItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $total_given_amount = Payment::where('user_id', Auth::user()->id)->where('project_id', $this->project->id)->where('status_code', '00')->sum('given_amount');

        return [
            'id' => $this->project->id,
            "featured_image_url" => $this->project->featured_image_url,
            'category' => $this->project->category->name,
            "location" => $this->project->location,
            'name' => $this->project->name,
            "total_given_amount" => $total_given_amount
        ];
    }
}
