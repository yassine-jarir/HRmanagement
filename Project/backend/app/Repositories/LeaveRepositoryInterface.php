<?php
namespace App\Repositories;

use App\Models\leaveReq;

interface LeaveRepositoryInterface
{
    public function create(array $data);
    public function update(int $id, array $data);
    public function getAll();
    public function getById(int $id);
}
