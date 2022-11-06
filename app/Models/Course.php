<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id')->withDefault([
            'name' => 'none'
        ]);
    }
    public function trainer(){
        return $this->belongsTo(Trainer::class,'trainer_id','id')->withDefault([
            'name' => 'none'
        ]);
    }
    public function group(){
        return $this->belongsTo(Group::class,'group_id','id')->withDefault([
            'name' => 'none'
        ]);
    }
}
