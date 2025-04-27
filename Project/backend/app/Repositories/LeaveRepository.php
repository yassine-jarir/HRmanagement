<?php
namespace App\Repositories;

use App\Models\leaveReq;

class LeaveRepository implements LeaveRepositoryInterface
{
    public function create(array $data)
    {
        return leaveReq::create($data);
    }

    public function update( $id,  $status)
    {
        $leaveRequest = leaveReq::findOrFail($id);
        $leaveRequest->status = $status;
        $leaveRequest->save();
        return $leaveRequest;
    }

    public function getAll()
    {
        return LeaveReq::with('user:id,name')->get();
    }

    public function getById(int $id)
    {
        return leaveReq::findOrFail($id);
    }
}
