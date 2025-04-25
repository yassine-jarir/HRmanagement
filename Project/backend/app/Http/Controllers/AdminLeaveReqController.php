<?php
namespace App\Http\Controllers;

use App\Models\leaveReq;
 use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLeaveReqController extends Controller
{
     public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'type' => 'required|string',
            'reason' => 'required|string',
        ]);
    
        $leaveRequest = leaveReq::create([
            'emplyee_id' => Auth::user()->id,  
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'type' => $request->type,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return response()->json($leaveRequest, 201);
    }

     public function update(Request $request, $id)
    {
        $leaveRequest = leaveReq::findOrFail($id);

        $request->validate([
            'status' => 'required|in:approved,rejected,pending',
        ]);

        $leaveRequest->status = $request->status;
        $leaveRequest->save();

        return response()->json($leaveRequest);
    }

     public function index()
    {
        return response()->json(leaveReq::all());
    }

     public function show($id)
    {
        $leaveRequests = leaveReq::where('id', $id)->get();
        return response()->json($leaveRequests);
    }
}