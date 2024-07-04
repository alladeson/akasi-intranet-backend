<?php

namespace App\Http\Resources;

use App\Models\Member;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
/*         $member = Member::where('user_id', $this->id)->get();
 */
        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'title' => $this->title,
            'address' => $this->address,
            'civic_code' => $this->civic_code,
            'zip_code' => $this->zip_code,
            'phone' => $this->phone,
            'mobile' => $this->mobile,
            'emergency_person1' => $this->emergency_person1,
            'emergency_phone1' => $this->emergency_phone1,
            'emergency_person1_relationship' => $this->emergency_person1_relationship,
            'emergency_person2' => $this->emergency_person2,
            'emergency_phone2' => $this->emergency_phone2,
            'emergency_person2_relationship' => $this->emergency_person2_relationship,
            'cv' => $this->cv,
            'profil' => $this->profil,
            'gender' => $this->gender,
/*             'team_role' => ( count($member) != 0) ? $member[0]->role : "InformationNA",
'team' => (count($member) != 0) ? Team::find($member[0]->team_id)->name : "InformationNA",
 */'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
