<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Message extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'short_message' => substr($this->message, 1, 50).'...',
            'message' => $this->message,
            'status' => $this->status,
            'created_at' => date('F d, Y', strtotime($this->created_at)),

            'del_loading' => false,
        ];
    }
}
