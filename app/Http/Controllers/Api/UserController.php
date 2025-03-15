<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\AvailableTimeRepositoryInterface;
use App\Repositories\Interfaces\AppointmentRepositoryInterface;
use App\Services\WhatsAppNotificationService;
use App\Models\OtpCode;
use Illuminate\Http\Request;
use App\Http\Requests\AvailableTimeIdRequest; 
use App\Http\Requests\VerifyOTPRequest; 
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;


class UserController extends Controller
{
    protected $userRepository;
    protected $availableTimeRepository;
    protected $appointmentRepository;
    protected $whatsappService;

    public function __construct(
        UserRepositoryInterface $userRepository,
        AvailableTimeRepositoryInterface $availableTimeRepository,
        AppointmentRepositoryInterface $appointmentRepository,
        WhatsAppNotificationService $whatsappService
    ) {
        $this->userRepository = $userRepository;
        $this->availableTimeRepository = $availableTimeRepository;
        $this->appointmentRepository = $appointmentRepository;
        $this->whatsappService = $whatsappService;
    }

    public function sendOtp(Request $request)
    {
        $phone = $request->validate(['phone' => 'required']);
        // $code = rand(100000, 999999);
        $code = '123456';
        OtpCode::create([
            'phone' => $phone['phone'],
            'code' => $code,
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);
        
        $message = "Your OTP code. ". $code;
        // $this->whatsappService->send($phone['phone'], $message);

        return response()->json(['message' => 'OTP sent']);
    }

    public function verifyOtp(VerifyOTPRequest $request): JsonResponse
    {
        $otp = OtpCode::where('phone', $request->phone)
            ->where('code', $request->code)
            ->where('expires_at', '>', Carbon::now())
            ->first();
        if (!$otp) {
            return response()->json(['error' => 'Invalid or expired OTP'], 400);
        }
        $user = $this->userRepository->findByPhone($request->phone);
        $user['token'] = JWTAuth::fromUser($user);
        return response()->json(['user' => $user]);
    }

    public function getAvailableTimes($doctorId): JsonResponse
    {     
        $times = $this->availableTimeRepository->getAvailableTimes($doctorId);
        return response()->json($times, 200);
    }

    public function bookAppointment(AvailableTimeIdRequest $request): JsonResponse
    {
        $time = $this->availableTimeRepository->find($request->available_time_id);
        if ($time->is_booked) {
            return response()->json(['error' => 'Time already booked'], 400);
        }
        $time->update(['is_booked' => true]);
        $appointment = $this->appointmentRepository->create([
            'patient_id' => auth()->id(),
            'available_time_id' => $request->available_time_id,
        ]);
        return response()->json($appointment, 201);
    }

    public function cancelAppointment($appointmentId): JsonResponse
    {
        $this->appointmentRepository->cancel($appointmentId);
        return response()->json(['message' => 'Appointment cancelled']);
    }

} // end of UserController