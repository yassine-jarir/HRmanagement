<?php

namespace App\Repositories;

use App\Models\Tasks;
 use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface
{
    public function getAll(): Collection;
    public function getTasksForUser($userId): Collection;
    public function create(array $data): Tasks;
    public function update(Tasks $task, array $data): bool;
    public function delete(Tasks $task): bool;
    public function getOneemployee( $userId);
}
