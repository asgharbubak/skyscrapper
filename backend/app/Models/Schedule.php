<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Schedule extends Model
{
    use HasFactory;


    public function teacher(){
        return $this->belongsTo("App\Models\Teacher", 'teacher_id');
    }

    public function cls(){
        return $this->belongsTo("App\Models\Classes", 'class_id');
    }

    public function subject(){
        return $this->belongsTo("App\Models\Subject", 'subject_id');
    }
}
