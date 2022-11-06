<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function student(){
        return $this->belongsTo(Student::class,'student_id','id')->withDefault([
            'name' => 'none'
        ]);
    }
    public function group(){
        return $this->belongsTo(Group::class,'group_id','id')->withDefault([
            'name' => 'none'
        ]);
    }
    public function platform(){
        return $this->belongsTo(Platform::class,'platform_id','id')->withDefault([
            'name' => 'none'
        ]);
    }
}
