<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmoloyeeManageTasksController extends Controller
{
    public function updateTaskStatus(Request $request, $taskId)
    {
        $request->validate([
            'status' => 'required|in:to_do,in_progress,completed'
        ]);

        $task = Tasks::whereHas('users', function($query) {
            $query->where('users.id', Auth::id());
        })->findOrFail($taskId);

        $task->status = $request->status;
        $task->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Task status updated successfully',
            'data' => $task
        ], 200);
    }


}
