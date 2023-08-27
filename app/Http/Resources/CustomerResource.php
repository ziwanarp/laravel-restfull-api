<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return
        [
            'status' => true,
            'message' => 'success',
            'data' => [
                'id' => $this->id,
                'title' => $this->title,
                'name' => $this->name,
                'gender' => $this->gender,
                'phone_number' => $this->phone_number,
                'image' => $this->image,
                'email' => $this->email,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'address' => $this->address
            ],
        ];
    }
}
