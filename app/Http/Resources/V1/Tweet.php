<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Tweet extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_slug' => $this->slug,
            'user_full_name' => $this->name,
            'created_at' => $this->created_at->toDateString(),
            'tweets' => $this->tweet,
        ];
    }

    public function with($request){
        return [
          'version' => '1.0.0',
          'author_url' => url('http://martinchea.com')
        ];
    }
}
