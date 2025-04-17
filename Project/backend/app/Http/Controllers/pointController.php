<?php

namespace App\Http\Controllers;

use App\Models\Pointage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class pointController extends Controller
{
    public function index(){
        return response()->json([
            'pointages' => Pointage::where('employee_id', Auth::user()->id)->get()
        ]);
    }
    public function startWork(Request $request){
      $request->validate([
              'employee_id' => 'required|exists:users,id',
            'task_id' => 'required|exists:Tasks,id'
        ]);

        
        $pointage = Pointage::create([
            'start_time' => now(),
            'end_time' => null,
            'employee_id' => $request->employee_id,
            'task_id' => $request->task_id
        ]);

        return response()->json([
            'message' => 'work created successfully',
            'pointage' => $pointage
        ]);
    }
    public function endWork(Request $request){
        $pointage = Pointage::where('employee_id',Auth::user()->id)
            ->whereNull('end_time')
            ->first();
        $pointage->end_time = now();
        $pointage->save();

        return response()->json([
            'message' => 'work ended successfully',
            'pointage' => $pointage
        ]);
    }

}
