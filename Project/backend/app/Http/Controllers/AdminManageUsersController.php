<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;

class AdminManageUsersController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $employees = $this->userRepository->getAll();
        return response()->json($employees);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'nullable|string',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        $employee = $this->userRepository->create($validated);

        return response()->json($employee, 201);
    }

    public function show($id)
    {
        $employee = $this->userRepository->findById($id);
        return response()->json($employee);
    }

    public function update(Request $request, $id)
    {
        $employee = $this->userRepository->findById($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $id,
            'password' => 'sometimes|nullable|min:6',
            'role' => 'nullable|string',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $this->userRepository->update($employee, $validated);

        return response()->json($employee);
    }

    public function destroy($id)
    {
        $employee = $this->userRepository->findById($id);
        $this->userRepository->delete($employee);

        return response()->json(['message' => 'Employee deleted successfully']);
    }
}
