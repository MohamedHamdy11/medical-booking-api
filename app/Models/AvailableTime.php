<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableTime extends Model
{
    use HasFactory;

    protected $table = 'available_times';
    protected $fillable = ['doctor_id', 'date', 'start_time', 'end_time', 'duration', 'is_booked', 'created_at', 'updated_at'];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function appointment()
    {
        return $this->hasOne(Appointment::class);
    }

} // end of AvailableTime
