<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorAvailability extends Model
{
    use HasFactory;
    protected $table = 'doctor_availability';
    public $timestamps = false;


    protected $fillable = ['doctor_id', 'available_date', 'max_appointments', 'current_appointments'];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function hasAvailableSlots()
    {
        return $this->current_appointments < $this->max_appointments;
    }
}
