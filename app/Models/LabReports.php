<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabReports extends Model
{
    protected $table = 'lab_reports';
    protected $fillable = ['test_name','result','report_file','created_at','updated_at','patient_id','doctor_id'];

    public function patient(){
        return $this->belongsTo(User::class,'patient_id');
    }
    public function doctor(){
        return $this->belongsTo(User::class,'doctor_id');
    }
    use HasFactory;
}
