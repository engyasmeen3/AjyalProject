<?php
 
namespace App\Http\Resources;
 
use Illuminate\Http\Resources\Json\JsonResource;
 
class StudentResource extends JsonResource
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
            'ar_fname' => $this->ar_fname,
            'ar_mname' => $this->ar_mname,
            'ar_family' => $this->ar_family,
            'en_fname' => $this->en_fname,
            'en_mname' => $this->en_mname,
            'en_lname' => $this->en_lname,
            'card_id' => $this->ar_mname,
            'mobile' => $this->mobile,
            //'category_id' => $this->category_id,
            'specialization' => $this->specialization,
            'country' => $this->country,
            //'user_id' => $this->user_id,
            'dob'=> $this->dob,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
 
        ];
    }
}
