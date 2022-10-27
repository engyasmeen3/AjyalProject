<?php
 
namespace App\Http\Resources;
 
use Illuminate\Http\Resources\Json\JsonResource;
 
class CourseResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
          //  'trainer_id' => $this->trainer_id,
          //  'group_id' => $this->group_id,
           // 'category_id' => $this->category_id,
            'status' => $this->status,
            'course_time' => $this->course_time,
            'status' => $this->status,
            'course_time' => $this->course_time,
            'short_description' => $this->short_description,
            'starts_at' => $this->starts_at,
            'ends_at' => $this->ends_at,
            'image'   =>$this->image,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

