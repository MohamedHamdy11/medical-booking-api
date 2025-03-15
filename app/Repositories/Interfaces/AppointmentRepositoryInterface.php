<?php

namespace App\Repositories\Interfaces;

interface AppointmentRepositoryInterface
{
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function cancel($id);
    public function complete($id);
    public function find($id);
    public function all();
}