<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JsonFailResource extends JsonResource
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
            'status' => isset($this->resource['status']) ? $this->resource['status'] : false,
            'message' => 'Data Not Found',
            'data' => null
        ];
    }
}
