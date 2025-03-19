<?php

namespace App\Models;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{

    protected $table = 'payments';


    protected $fillable = ['amount','payment_method','status','patient_id','doctor_id','appointment_id','lab_report_id'];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    // Relationship with Doctor
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    // Relationship with Appointment
    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    // Relationship with LabReport (if payment is for lab tests)
    // public function labReport()
    // {
    //     return $this->belongsTo(LabReport::class, 'lab_report_id');
    // }
    use HasFactory;
}
