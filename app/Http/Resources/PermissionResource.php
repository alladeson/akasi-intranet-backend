<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
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
            'object' => $this->object,
            'reasons' => $this->reasons,
            'piece' => $this->piece,
            'duration' => $this->duration,
            'starting_date' => $this->starting_date,
            'ending_date' => $this->ending_date,
            'status' => $this->status,
            'pdf' => $this->pdf,
            'user' => User::withTrashed()->find($this->user_id),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
