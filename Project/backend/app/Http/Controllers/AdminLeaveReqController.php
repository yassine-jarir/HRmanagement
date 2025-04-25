<?php
namespace App\Http\Controllers;

use App\Repositories\LeaveRepository;
 use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLeaveReqController extends Controller
{
    protected $leaveRequestRepository;

    public function __construct(LeaveRepository $leaveRequestRepository)
    {
        $this->leaveRequestRepository = $leaveRequestRepository;
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'type' => 'required|string',
            'reason' => 'required|string',
        ]);
    
        $leaveRequestData = [
            'emplyee_id' => Auth::user()->id,  
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'type' => $request->type,
            'reason' => $request->reason,
            'status' => 'pending',
        ];

        $leaveRequest = $this->leaveRequestRepository->create($leaveRequestData);

        return response()->json($leaveRequest, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending',
        ]);


        $leaveRequest = $this->leaveRequestRepository->update($id, $request->status);

        return response()->json($leaveRequest);
    }

    public function index()
    {
        $leaveRequests = $this->leaveRequestRepository->getAll();
        return response()->json($leaveRequests);
    }

    public function show($id)
    {
        $leaveRequest = $this->leaveRequestRepository->getById($id);
        return response()->json($leaveRequest);
    }
}
