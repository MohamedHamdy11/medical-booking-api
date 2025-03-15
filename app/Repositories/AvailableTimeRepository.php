<?php

namespace App\Repositories;

use App\Models\AvailableTime;
use App\Repositories\Interfaces\AvailableTimeRepositoryInterface;
use Carbon\Carbon;

class AvailableTimeRepository implements AvailableTimeRepositoryInterface
{
    public function create(array $data)
    {
        return AvailableTime::create($data);
    }

    public function update($id, array $data)
    {
        $time = AvailableTime::findOrFail($id);
        $time->update($data);
        return $time;
    }

    public function delete($id)
    {
        $time = AvailableTime::findOrFail($id);
        $time->delete();
    }

    public function getAvailableTimes($doctorId)
    {
        return AvailableTime::with('doctor')->where('doctor_id', $doctorId)
            ->where('is_booked', false)
            ->where('date', '>=', Carbon::today())
            ->get();
    }

    public function find($id)
    {
        return AvailableTime::findOrFail($id);
    }

    public function all()
    {
        return AvailableTime::with('doctor')->get();
    }

} // end of AvailableTimeRepository