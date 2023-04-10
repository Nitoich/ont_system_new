<?php

namespace App\Http\Resources\Proofreading;

use Illuminate\Http\Resources\Json\JsonResource;

class ProofreadingResource extends JsonResource
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
            'user_id' => $this->user_id,
            'date' => $this->date,
            'discipline_id' => $this->discipline_id,
            'group_id' => $this->group_id,
            'user_name' => $this->user->email,
            'discipline_name' => $this->discipline->name,
            'group_name' => $this->group->name,
            'hours' => $this->hours
        ];
    }
}
