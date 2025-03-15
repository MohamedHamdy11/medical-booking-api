<?php

namespace App\Repositories;

use App\Models\Appointment;
use App\Repositories\Interfaces\AppointmentRepositoryInterface;
use Carbon\Carbon;

class AppointmentRepository implements AppointmentRepositoryInterface
{
    public function create(array $data)
    {
        return Appointment::create($data);
    }

    public function update($id, array $data)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update($data);
        return $appointment;
    }

    public function delete($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->availableTime->update(['is_booked' => false]);
        $appointment->delete();
    }

    public function cancel($id)
    {
        $appointment = Appointment::findOrFail($id);
        $time = $appointment->availableTime;
        if (Carbon::now()->diffInHours($time->start_time) < 3) {
            throw new \Exception('Cannot cancel less than 3 hours before appointment.');
        }
        $time->update(['is_booked' => false]);
        $appointment->delete();
    }

    public function complete($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update(['is_completed' => true]);
    }

    public function find($id)
    {
        return Appointment::findOrFail($id);
    }

    public function all()
    {
        return Appointment::all();
    }

} // end of AppointmentRepository