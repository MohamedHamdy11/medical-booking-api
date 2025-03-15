<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function findByPhone($phone);
    // public function create(array $data);
}