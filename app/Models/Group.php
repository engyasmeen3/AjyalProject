<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function project(){
        return $this->belongsTo(Project::class,'project_id','id')->withDefault([
            'name' => 'none'
        ]);
    }

    public function contracts(){
        return $this->hasMany(Contract::class);
    }
    public function courses(){
        return $this->hasMany(Course::class);
    }
}
