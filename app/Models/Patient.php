<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    protected $table = 'patient';
    public $timestamps = false;

    protected $fillable = ['DOB','blood_group','phone','users_id'];

    public function user(){
        return $this->belongsTo(User::class,'users_id');
    }
    use HasFactory;
}
