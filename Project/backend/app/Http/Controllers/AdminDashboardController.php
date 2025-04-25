<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tasks;
use App\Models\Payroll;
use Illuminate\Support\Carbon;

class AdminDashboardController extends Controller
{
    public function getPayrollChart()
    {
        try {
             $monthlyPayroll = [];
            for ($i = 0; $i < 6; $i++) {
                $date = Carbon::now()->subMonths($i);
                $total = Payroll::whereYear('payment_date', $date->year)
                    ->whereMonth('payment_date', $date->month)
                    ->sum('salary');
                
                $monthlyPayroll[] = [
                    'month' => $date->format('M'),  
                    'total' => round($total, 2)
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

    public function getDashboardStats()
    {
        try {
             $totalEmployees = User::where('role', '!=', 'admin')->count();

             $totalTasks = Tasks::count();
            $activeTasks = Tasks::where('status', 'in_progress')->count();
            $completedTasks = Tasks::where('status', 'completed')->count();

             $currentMonth = Carbon::now()->month;
            $totalPayroll = Payroll::whereMonth('payment_date', $currentMonth)
                ->sum('salary');

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
                'error' => 'Failed to fetch dashboard statistics'
            ], 500);
        }
    }
}
