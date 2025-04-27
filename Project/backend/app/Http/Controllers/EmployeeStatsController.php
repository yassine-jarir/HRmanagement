<?php

namespace App\Http\Controllers;

use App\Models\Pointage;
use App\Models\Tasks;
use App\Models\leaveReq;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmployeeStatsController extends Controller
{
    public function getTaskStats()
    {
        $userId = Auth::id(); 
    
        $totalTasks = Tasks::whereHas('users', function($query) use ($userId) {
            $query->where('users.id', $userId);
        })->count();
    
        $activeTasks = Tasks::whereHas('users', function($query) use ($userId) {
            $query->where('users.id', $userId);
        })->where('status', 'in_progress')->count();

        $completedTasks = Tasks::whereHas('users', function($query) use ($userId) {
            $query->where('users.id', $userId);
        })->where('status', 'completed')->count();

        $toDoTasks = Tasks::whereHas('users', function($query) use ($userId) {
            $query->where('users.id', $userId);
        })->where('status', 'to_do')->count();

        return response()->json([
            'tasks' => [
                'total' => $totalTasks,
                'active' => $activeTasks,
                'completed' => $completedTasks,
                'to_do' => $toDoTasks,
            ]
        ]);
    }
    

    public function getLeaveStats()
    {
        $userId = Auth::id();
    
        $leaveStats = [
            'rejected' => leaveReq::where('emplyee_id', $userId)->where('status', 'rejected')->count(),
            'approved' => leaveReq::where('emplyee_id', $userId)->where('status', 'approved')->count(),
            'pending' => leaveReq::where('emplyee_id', $userId)->where('status', 'pending')->count(),
        ];

      $total_leaves =  leaveReq::where('emplyee_id', $userId)->count();
        return response()->json([
            'approved' => $leaveStats['approved'],
            'rejected' => $leaveStats['rejected'],
            'pending' => $leaveStats['pending'],
            'total_leaves' => $total_leaves
        ]);
    }
    

    public function calculSalaryHours()
    {
        $totalHours = 0;
        $pointages = Pointage::where('employee_id', Auth::user()->id)->get();

         foreach ($pointages as $pointage) {
            $start_time = Carbon::parse($pointage->start_time);
            $end_time = $pointage->end_time ? Carbon::parse($pointage->end_time) : null;

            if ($end_time) {
                $totalHours += $start_time->diffInHours($end_time);
            }
        }
        return response()->json([
            'message' => 'Payroll calculated and saved successfully',
            'totalHours' => round($totalHours, 2),
            'salary' => round($totalHours * 20, 2),
        ]);
    }
}
