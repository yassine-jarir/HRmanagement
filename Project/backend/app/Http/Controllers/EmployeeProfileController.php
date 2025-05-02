<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class EmployeeProfileController extends Controller
{
    public function show()
    {
        $employee = User::where('id', Auth::user()->id)->first();
        return response()->json([
            'employee' => $employee,
        ]);
    }

     public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::user()->id,
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'profile_image' => 'nullable|string', 
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }
    
         $employee = Auth::user();
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->address = $request->address;
        $employee->department = $request->department;
    
         if (  $request->profile_image) {
            
            if ($employee->profile_image && Storage::disk('public')->exists($employee->profile_image)) {
                Storage::disk('public')->delete($employee->profile_image);
            }
    
            $imageData = base64_decode($request->profile_image);
            $imageName = 'profile-' . time() . '.png';   
            $imagePath = 'profile-images/' . $imageName;
    
             Storage::disk('public')->put($imagePath, $imageData);
    
             $employee->profile_image = $imagePath;
        }
    
        $employee->save();
    
        return response()->json([
            'message' => 'Profile updated successfully',
            'employee' => $employee,
        ], 200);
    }
    
 
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $employee = Auth::user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $employee->password)) {
            return response()->json([
                'message' => 'Current password is incorrect',
            ], 400);
        }

        $employee->password = Hash::make($request->password);
        $employee->save();

        return response()->json([
            'message' => 'Password updated successfully',
            'employee' => $employee,
        ], 200);
    }
}