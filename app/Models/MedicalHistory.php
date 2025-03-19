<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicalHistory extends Model
{
    protected $table = 'medical_history';
    protected $fillable = ['diagnosis','created_at','updated_at','doctor_id','patient_id','treatment'];

    public function patient(){
        return $this->belongsTo(User::class,'patient_id');
    }
    public function doctor(){
        return $this->belongsTo(User::class,'doctor_id');
    }

    use HasFactory;
}
