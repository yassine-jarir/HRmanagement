<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmployeeProfileController extends Controller
{
     public function show()
    {
        $employee = User::where('id', Auth::user()->id)->first();
        return response()->json([
            'employee' => $employee,
        ]);
    }

    public function update(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::user()->id,  
            'password' => 'nullable|min:6|confirmed|n',  
        ]);

    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 400);
        }
        $employee = Auth::user();
        $employee->name = $request->name;
        $employee->email = $request->email;

         if ($request->filled('password')) {
            $employee->password = Hash::make($request->password);
        }

         $employee->save();

        return response()->json([
            'message' => 'Profile updated successfully',
            'employee' => $employee,
        ], 200);
    }
}
