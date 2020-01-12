<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Post;
use App\User;

class Comment extends JsonResource
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
            'post_id' => $this->post_id,
            'image' => Post::getPostImage($this->post_id),
            'name' => User::getUserName($this->user_id),
            'comment' => $this->comment,
            'status' => $this->status,
            'created_at' => date('F d, Y', strtotime($this->created_at)),

            'active_loading' => false,
            'del_loading' => false,
        ];
    }
}
