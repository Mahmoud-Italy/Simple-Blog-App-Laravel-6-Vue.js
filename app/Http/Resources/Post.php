<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Post_tag;
use App\User;

class Post extends JsonResource
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
            'image' => $this->image,
            'permalink' => str_replace(' ','-',strtolower($this->title)),
            'title' => $this->title,
            'short_content' => substr($this->content, 1, 150).'...',
            'content' => $this->content,
            'status' => $this->status,
            'created_at' => date('F d, Y', strtotime($this->created_at)),

            'author_name' => User::getUserName($this->user_id),
            'tags' => Post_tag::getTags($this->id),

            'active_loading' => false,
            'del_loading' => false,
        ];
    }
}
