<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Role;

class Author extends JsonResource
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
            'status' => $this->status,
            'created_at' => (isset($this->created_at)) ? explode(' ',$this->created_at)[0] : '',

                'has_creates' => Role::getRoles($this->id, 'creates'),
                'has_shows' => Role::getRoles($this->id, 'shows'),
                'has_updates' => Role::getRoles($this->id, 'updates'),
                'has_deletes' => Role::getRoles($this->id, 'deletes'),

            'active_loading' => false,
            'del_loading' => false,
        ];
    }
}
