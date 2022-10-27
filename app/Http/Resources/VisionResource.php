<?php
 
namespace App\Http\Resources;
 
use Illuminate\Http\Resources\Json\JsonResource;
 
class VisionResource extends JsonResource
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
            'id'          => $this->id,
            'name'        => $this->name,
            'vision'      => $this->vision,
            'letter'      => $this->letter,
            'description' => $this->description,
            'email'       =>$this->email,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
        ];
    }
}