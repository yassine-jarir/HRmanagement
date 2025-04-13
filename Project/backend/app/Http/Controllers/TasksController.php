<?php
namespace App\Http\Controllers;
 use App\Models\Tasks;
use App\Models\User;
use Illuminate\Http\Request;

class TasksController 
{
     public function index()
    {
        $tasks = Tasks::with('users')->get();
        return response()->json($tasks);
    }

     public function show($id)
    {
        $task = Tasks::with('users')->findOrFail($id);
        return response()->json($task);
    }

     public function store(Request $request)
    {
        $validated = $request->validate([
            'task_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $task = Tasks::create([
            'task_name' => $validated['task_name'],
            'description' => $validated['description'] ,
        ]);

        $task->users()->attach($validated['user_ids']);

        return response()->json(['message' => 'Task created and assigned', 'task' => $task->load('users')]);
    }

     public function update(Request $request, $id)
    {
        $task = Tasks::findOrFail($id);

        $validated = $request->validate([
            'task_name' => 'string|max:100',
            'description' => 'string',
            'user_ids' => 'array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $task->update($validated);

        if (isset($validated['user_ids'])) {
            $task->users()->sync($validated['user_ids']);
        }

        return response()->json(['message' => 'Task updated', 'task' => $task->load('users')]);
    }

     public function destroy($id)
    {
        $task = Tasks::findOrFail($id);
        $task->delete();

        return response()->json(['message' => 'Task deleted']);
    }

     public function getUsers()
    {
        $users = User::select('id', 'name')->get();
        return response()->json($users);
    }
}
