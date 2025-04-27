<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tasks;
use App\Models\Payroll;
use App\Models\Pointage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function getAdminPayrollChart()
    {
        try {
            $monthlyPayroll = [];
    
             for ($i = 0; $i < 6; $i++) {
                $date = Carbon::now()->subMonths($i);
    
                $totalPayroll = 0;
    
                 $users = User::where('role', 'employee')->get();
    
                 foreach ($users as $user) {
                    $totalHours = 0;
    
                     $pointages = Pointage::where('employee_id', $user->id)
                        ->whereYear('start_time', $date->year)
                        ->whereMonth('start_time', $date->month)
                        ->get();
    
                     foreach ($pointages as $pointage) {
                        $start_time = Carbon::parse($pointage->start_time);
                        $end_time = $pointage->end_time ? Carbon::parse($pointage->end_time) : null;
    
                         if ($end_time) {
                            $totalHours += $start_time->diffInMinutes($end_time) / 60;  
                        }
                    }
    
                    $totalPayroll += round($totalHours * 20, 2); 
                }
    
                $monthlyPayroll[] = [
                    'month' => $date->format('M'),   
                    'total' => round($totalPayroll, 2) 
                ];
            }
    
            $monthlyPayroll = array_reverse($monthlyPayroll);
    
            return response()->json([
                'payroll_data' => $monthlyPayroll
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch payroll data'
            ], 500);
        }
    }
    

    public function getAdminStats()
    {
        try {
            $totalEmployees = User::where('role', 'employee')->count();
            $totalTasks = Tasks::count();
            $activeTasks = Tasks::where('status', 'in_progress')->count();
            $completedTasks = Tasks::where('status', 'completed')->count();

            $totalPayroll = 0;

            $users = User::where('role', 'employee')->get();
            foreach ($users as $user) {
                $totalHours = 0;
    
                
                $pointages = Pointage::where('employee_id', $user->id)
                    ->get();
    
                
                foreach ($pointages as $pointage) {
                    $start_time = Carbon::parse($pointage->start_time);
                    $end_time = $pointage->end_time ? Carbon::parse($pointage->end_time) : null;
    
                 
                    if ($end_time) {
                        $totalHours += $start_time->diffInMinutes($end_time) / 60;   
                    }
                }
    
                $totalPayroll += round($totalHours * 20, 2);  
            }
            return response()->json([
                'total_employees' => $totalEmployees,
                'tasks' => [
                    'total' => $totalTasks,
                    'active' => $activeTasks,
                    'completed' => $completedTasks
                ],
                'total_payroll' => round($totalPayroll, 2)   
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch dashboard statistics',
                'message' => $e->getMessage(),   
            ], 500);
        }
    }
}
