<?php

namespace App\Models;

use App\Models\User;
use App\Models\DoctorCategory;
use App\Models\DoctorAvailability;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
    protected $table = 'doctor'; // Keep this if your table name is singular
    public $timestamps = false;
    protected $fillable = ['specialization', 'phone', 'work_hospital', 'users_id', 'doctor_category_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function category()
{
    return $this->belongsTo(DoctorCategory::class, 'doctor_category_id');
}


    public function availability()
    {
        return $this->hasMany(DoctorAvailability::class, 'doctor_id');
    }
    
}

