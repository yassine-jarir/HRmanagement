<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use App\Models\User;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminTasksController extends Controller
{
    protected $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function index()
    {
        $tasks = $this->taskRepository->getAll();
        return response()->json($tasks);
    }

    public function show()
    {
        $userId = Auth::user()->id;
        $tasks = $this->taskRepository->getTasksForUser($userId);
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $task = $this->taskRepository->create($validated);

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

        $this->taskRepository->update($task, $validated);

        return response()->json(['message' => 'Task updated', 'task' => $task->load('users')]);
    }

    public function destroy($id)
    {
        $task = Tasks::findOrFail($id);
        $this->taskRepository->delete($task);

        return response()->json(['message' => 'Task deleted']);
    }

    public function getUsers()
    {
        $users = User::select('id', 'name')->get();
        return response()->json($users);
    }
}
