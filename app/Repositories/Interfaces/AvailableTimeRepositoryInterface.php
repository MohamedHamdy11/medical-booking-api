<?php

namespace App\Repositories\Interfaces;

interface AvailableTimeRepositoryInterface
{
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function getAvailableTimes($doctorId);
    public function find($id);
    public function all();
}