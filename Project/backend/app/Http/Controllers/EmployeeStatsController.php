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
        
        $taskStats = Tasks::whereHas('users', function($query) use ($userId) {
            $query->where('users.id', $userId);
        })
        ->select('status', DB::raw('count(*) as count'))
        ->groupBy('status')
        ->get();

        $monthlyTaskCompletion = Tasks::whereHas('users', function($query) use ($userId) {
            $query->where('users.id', $userId);
        })
        ->where('status', 'completed')
        ->count();

        return response()->json([
            'task_status_distribution' => $taskStats,
            'monthly_completed_tasks' => $monthlyTaskCompletion
        ]);
    }

    public function getLeaveStats()
    {
        $userId = Auth::id();
        
        $leaveStats = leaveReq::where('emplyee_id', $userId)
            ->select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->get();

        $monthlyLeaves = leaveReq::where('emplyee_id', $userId)
            ->where('start_date', '>=', Carbon::now()->startOfMonth())
            ->count();

        return response()->json([
            'leave_status_distribution' => $leaveStats,
            'monthly_leave_requests' => $monthlyLeaves
        ]);
    }
    public function calculSalaryHours()
    {
        $totalHours = 0;
        $salary = 0;
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
            'totalHours' => $totalHours,
            'salary' => $totalHours * 20,
        ]);
    }
}
