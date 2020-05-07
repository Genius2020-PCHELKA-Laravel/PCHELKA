<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'fullName' => $this->fullName,
            'password' => $this->password,
            'dateOfBirth' => $this->dateOfBirth,
            'gender' => $this->gender,
            'language' => $this->language
        ];
    }
}
