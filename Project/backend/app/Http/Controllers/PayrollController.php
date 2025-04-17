<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Pointage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


class PayrollController extends Controller
{
    public function calculPayroll(){
         $totalHours = 0;
        $pointages = Pointage::where('employee_id',Auth::user()->id)->get();

        foreach($pointages as $pointage){
            $start_time = Carbon::parse($pointage->start_time);
            $end_time = $pointage->end_time ? Carbon::parse($pointage->end_time) : null;
            if($pointage->end_time != null){
                $totalHours += $start_time->diffInHours($end_time);
            }
        }
        $payroll = Payroll::create([
            'user_id' => Auth::user()->id,
            'salary' => $this->calculateSalary($totalHours),
            'hours_worked' => $totalHours,
            'payment_date' => now(),   
        ]);
    
    
        return response()->json([
            'message' => 'Payroll calculated and saved successfully',
            'payroll' => $payroll
        ]);
    }
    public function calculateSalary($hoursWorked)
    {
        return $hoursWorked * 20;   
    }
}
