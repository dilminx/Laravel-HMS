<?php
namespace App\Models;

use App\Models\User;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DoctorAvailability extends Model
{
    use HasFactory;
    protected $table = 'doctor_availability';
    public $timestamps = false;


    protected $fillable = ['doctor_id', 'available_date', 'max_appointments', 'current_appointments'];
    // doctor_id==users table id

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');  // doctor_id refers to users table id
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'doctor_id');  // doctor_id refers to users table id
    }



    public function hasAvailableSlots()
    {
        return $this->current_appointments < $this->max_appointments;
    }
}
