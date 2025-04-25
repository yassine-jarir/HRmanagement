<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function getAll();
    public function create(array $data);
    public function findById($id);
    public function update(User $user, array $data);
    public function delete(User $user);
}