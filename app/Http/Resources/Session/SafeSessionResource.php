<?php

namespace App\Http\Resources\Session;

use Illuminate\Http\Resources\Json\JsonResource;

class SafeSessionResource extends JsonResource
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
            'device_name' => $this->device_name,
            'last_updated' => $this->updated_at
        ];
    }
}
