<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AvailableTime;
use Carbon\Carbon;

class AvailableTimeSeeder extends Seeder
{
    public function run(): void
    {
        $times = [
            [
                'doctor_id' => 1,
                'date' => Carbon::today()->toDateString(), 
                'start_time' => '14:00:00',
                'end_time' => '14:30:00',
                'duration' => 30,
                'is_booked' => false,
            ],
            [
                'doctor_id' => 1,
                'date' => Carbon::today()->toDateString(), 
                'start_time' => '15:30:00',
                'end_time' => '16:00:00',
                'duration' => 30,
                'is_booked' => false,
            ],
            [
                'doctor_id' => 1,
                'date' => Carbon::today()->toDateString(), 
                'start_time' => '17:00:00',
                'end_time' => '17:30:00',
                'duration' => 30,
                'is_booked' => false,
            ],
            
            [
                'doctor_id' => 2,
                'date' => Carbon::today()->toDateString(), 
                'start_time' => '14:00:00',
                'end_time' => '14:30:00',
                'duration' => 30,
                'is_booked' => false,
            ],
            [
                'doctor_id' => 2,
                'date' => Carbon::today()->toDateString(), 
                'start_time' => '15:30:00',
                'end_time' => '16:00:00',
                'duration' => 30,
                'is_booked' => false,
            ],
            [
                'doctor_id' => 2,
                'date' => Carbon::today()->toDateString(), 
                'start_time' => '17:00:00',
                'end_time' => '17:30:00',
                'duration' => 30,
                'is_booked' => false,
            ],
        ];

        foreach ($times as $time) {
            AvailableTime::create($time);
        }
    }
}