<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
/*         return parent::toArray($request);
 */
        return [
            'id' => $this->id,
            'goals' => $this->goals,
            'achievements' => $this->achievements,
            'observations' => $this->observations,
            'next_goals' => $this->next_goals,
            'status' => $this->status,
            'pdf' => $this->pdf,
            'validated' => $this->validated,
            'user' => User::withTrashed()->find($this->user_id),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

    }
}
