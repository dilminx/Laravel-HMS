<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctor'; // Keep this if your table name is singular
    public $timestamps = false;
    protected $fillable = ['specialization', 'phone', 'work_hospital', 'users_id', 'doctor_category_id'];

    public function user() { // ✅ Fix method name (was `doctors()`)
        return $this->belongsTo(User::class, 'users_id'); // Ensure correct foreign key
    }

    public function category() { // ✅ Fix foreign key reference
        return $this->belongsTo(DoctorCategory::class, 'doctor_category_id');
    }
}

