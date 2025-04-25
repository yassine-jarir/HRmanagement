<?php

namespace App\Repositories;

use App\Models\Tasks;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    public function getAll(): Collection
    {
        return Tasks::with('users')->get();
    }

    public function getTasksForUser($userId): Collection
    {
        return Tasks::whereHas('users', function($query) use ($userId) {
            $query->where('users.id', $userId);
        })->with('users')->get();
    }

    public function create(array $data): Tasks
    {
        $task = Tasks::create([
            'task_name' => $data['task_name'],
            'description' => $data['description'],
        ]);

        $task->users()->attach($data['user_ids']);

        return $task;
    }

    public function update(Tasks $task, array $data): bool
    {
        $task->update($data);

        if (isset($data['user_ids'])) {
            $task->users()->sync($data['user_ids']);
        }

        return true;
    }

    public function delete(Tasks $task): bool
    {
        return $task->delete();
    }
}
