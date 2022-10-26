<?php
 
namespace App\Http\Resources;
 
use Illuminate\Http\Resources\Json\JsonResource;
 
class ContractResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'student_id' => $this->student_id,
            'group_id' => $this->group_id,
            'platform_id' => $this->platform_id,
            'status' => $this->status,
            'amount' => $this->amount,
            'contract_image' => $this->contract_image,
            'period' => $this->period,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
