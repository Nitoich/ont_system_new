<?php

namespace App\Http\Resources\Loads;

use Illuminate\Http\Resources\Json\JsonResource;

class LoadResource extends JsonResource
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
            'group_id' => $this->group_id,
            'group_name' => $this->group->name,
            'discipline_id' => $this->discipline_id,
            'discipline_name' => $this->discipline->name,
            'semester_id' => $this->semester_id,
            'type' => $this->type,
            'characteristic' => $this->characteristic,
            'hours' => $this->hours
        ];
    }
}