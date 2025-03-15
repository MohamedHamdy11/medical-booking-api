<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';
    protected $fillable = ['patient_id', 'available_time_id', 'is_completed', 'created_at', 'updated_at'];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function availableTime()
    {
        return $this->belongsTo(AvailableTime::class);
    }

} // end of Appointment
