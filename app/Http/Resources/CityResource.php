<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CityResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'coat_of_arms_image' => $this->coat_of_arms_image,
            'card_text' => $this->card_text,
            'modal_title' => $this->modal_title,
            'modal_text' => $this->modal_text,
            'city_image' => $this->city_image,
            'wiki_url' => $this->wiki_url,
            'interesting_fact' => $this->interesting_fact,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'friendsWithAuthor' => Auth::check() && $this->owner ? Auth::user()->friendsWith($this->owner) : false,
        ];
    }
}
