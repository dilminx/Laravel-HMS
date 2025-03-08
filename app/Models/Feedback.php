<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback';
    protected $fillable = ['message','patient_id','doctor_id'];

    public function patient(){
        return $this->belongsTo(User::class,'patient_id');
    }
    public function doctor(){
        return $this->belongsTo(User::class,'doctor_id');
    }


    use HasFactory;
}

