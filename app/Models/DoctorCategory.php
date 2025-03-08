<?php

namespace App\Models;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DoctorCategory extends Model
{
    protected $table = 'doctor_category';
    protected $fillable = ['id','name','price'];

    public function doctorId() {
        return $this->hasMany(Doctor::class, 'category_id');
    }
    use HasFactory;
}
