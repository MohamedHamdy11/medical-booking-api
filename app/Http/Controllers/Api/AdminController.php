<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AvailableTimeRepositoryInterface;
use App\Repositories\Interfaces\AppointmentRepositoryInterface;
use App\Services\WhatsAppNotificationService;
use Illuminate\Http\Request;
use App\Http\Requests\CreateAvailableTimeRequest; 
use App\Http\Requests\UpdateAvailableTimeRequest; 
use App\Http\Requests\CreateAppointmentRequest; 
use App\Http\Requests\UpdateAppointmentRequest; 
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;


class AdminController extends Controller
{
    protected $availableTimeRepository;
    protected $appointmentRepository;
    protected $whatsappService;

    public function __construct(
        AvailableTimeRepositoryInterface $availableTimeRepository,
        AppointmentRepositoryInterface $appointmentRepository,
        WhatsAppNotificationService $whatsappService
    ) {
        $this->availableTimeRepository = $availableTimeRepository;
        $this->appointmentRepository = $appointmentRepository;
        $this->whatsappService = $whatsappService;
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('phone', 'password');
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return response()->json(['token' => $token]);
    }


    // CRUD for Available Times
    public function getAllAvailableTimes(): JsonResponse
    {
        $times = $this->availableTimeRepository->all();
        return response()->json($times);
    }

    public function createAvailableTime(CreateAvailableTimeRequest $request): JsonResponse
    {
        $data = $request->validated(); 
        $time = $this->availableTimeRepository->create($data);
        return response()->json($time, 201);
    }

    public function updateAvailableTime(UpdateAvailableTimeRequest $request, $id): JsonResponse
    {
        $data = $request->validated(); 
        $time = $this->availableTimeRepository->update($id, $data);
        return response()->json($time);
    }

    public function deleteAvailableTime($id): JsonResponse
    {
        $this->availableTimeRepository->delete($id);
        return response()->json(['message' => 'Available time deleted']);
    }



    // CRUD for Appointments
    public function getAllAppointments(): JsonResponse
    {
        $appointments = $this->appointmentRepository->all();
        return response()->json($appointments);
    }

    public function createAppointment(CreateAppointmentRequest $request): JsonResponse
    {
        $data = $request->validated();
        $time = $this->availableTimeRepository->find($data['available_time_id']);
        if ($time->is_booked) {
            return response()->json(['error' => 'Time already booked'], 400);
        }
        $time->update(['is_booked' => true]);
        $appointment = $this->appointmentRepository->create($data);
        return response()->json($appointment, 201);
    }

    public function updateAppointment(UpdateAppointmentRequest $request, $id): JsonResponse
    {
        $data = $request->validated();
        $appointment = $this->appointmentRepository->update($id, $data);
        return response()->json($appointment);
    }

    public function deleteAppointment($id): JsonResponse
    {
        $this->appointmentRepository->delete($id);
        return response()->json(['message' => 'Appointment deleted']);
    }

    
    public function completeExamination($appointmentId): JsonResponse
    {
        $this->appointmentRepository->complete($appointmentId);
    
        $appointments = $this->appointmentRepository->all()
            ->where('is_completed', false)
            ->sortBy('availableTime.start_time')
            ->values();
    
        $index = $appointments->search(fn($appt) => $appt->id == $appointmentId);
    
        if ($index === false && $appointments->count() >= 2) {
            $nextPatient = $appointments[1]->patient; 
            $message = "Your examination is approaching. Please be ready.";
            // $this->whatsappService->send($nextPatient->phone, $message);
        } elseif ($index !== false && $index + 2 < $appointments->count()) {
            $nextPatient = $appointments[$index + 2]->patient;
            $message = "Your examination is approaching. Please be ready.";
            // $this->whatsappService->send($nextPatient->phone, $message);
        }
    
        return response()->json(['message' => 'Examination completed']);
    }

} // end of AdminController