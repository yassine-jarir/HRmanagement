<?php

namespace App\Http\Controllers;

use App\Models\leaveReq;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class employeeLeaveRequest extends Controller
{
     public function index()
    {
         $employeeId = Auth::user()->id;
        
         $leaveRequests = leaveReq::where('emplyee_id', $employeeId)->get();

        return response()->json([
            'leave_requests' => $leaveRequests
        ]);
    }
     public function store(Request $request)
    {
         $validatedData = $request->validate([
            'type' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string',
        ]);

         $leaveRequest = leaveReq::create([
            'emplyee_id' => Auth::user()->id,
            'type' => $validatedData['type'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'reason' => $validatedData['reason'] ?? null,
            'status' => 'pending', 
        ]);

        return response()->json([
            'message' => 'Leave request submitted successfully',
            'leave_request' => $leaveRequest
        ], 201);
    }
     public function destroy($id)
    {
         $leaveRequest = leaveReq::find($id);

         if (!$leaveRequest || $leaveRequest->emplyee_id !== Auth::id()) {
            return response()->json([
                'message' => 'Leave request not found or you are not authorized to delete this request.'
            ], 404);
        }

         $leaveRequest->delete();

        return response()->json([
            'message' => 'Leave request deleted successfully'
        ]);
    }
}
