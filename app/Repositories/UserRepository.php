<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{

    public function findByPhone($phone)
    {
        $user = User::where('phone', $phone)->first();
        
        if (!$user) {
            $user = User::create([
                'phone' => $phone,
                'name' => 'User_' . $phone, 
                'email' => $phone . '@user.com', 
                'password' => Hash::make($phone), 
                'role' => 'patient', 
            ]);
        }

        return $user;
    }


    // public function create(array $data)
    // {
    //     return User::create($data);
    // }

} //end of UserRepository

