<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Pointage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminPayrollController extends Controller
{
    public function calculAllPayrolls()
    {
        $users = User::where('role', 'employee')->get();  
        $payrolls = [];
    
        foreach ($users as $user) {
            $totalHours = 0;
            $pointages = Pointage::where('employee_id', $user->id)->get();
    
            foreach ($pointages as $pointage) {
                $start_time = Carbon::parse($pointage->start_time);
                $end_time = $pointage->end_time ? Carbon::parse($pointage->end_time) : null;
    
                if ($end_time) {
                    $totalHours += $start_time->diffInMinutes($end_time) / 60;  
                }
            }
    
            $hourlyRate = 20;
            $payroll = Payroll::create([
                'user_id' => $user->id,
                'salary' => $totalHours * $hourlyRate, 
                'hours_worked' => $totalHours,
                'payment_date' => now(),
            ]);
    
            $payrolls[] = [
               
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                
                'salary' => $payroll->salary,
                'hours_worked' => $payroll->hours_worked,
                'payment_date' => $payroll->payment_date,
            ];
        }
    
        return response()->json([
            'message' => 'Payrolls for all employees calculated',
            'payrolls' => $payrolls
        ]);
    }
    
 
}
