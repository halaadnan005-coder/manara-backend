<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Child;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    // Get total users and children
    public function statistics()
    {
        $totalUsers = User::count();
        $totalChildren = Child::count();

        return response()->json([
            'total_users' => $totalUsers,
            'total_children' => $totalChildren,
        ]);
    }

    // Display users with search and pagination
    public function index(Request $request)
    {
        $query = User::query();

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Get 5 users per page
        $users = $query->select(
            'id',
            'name',
            'email',
            'role',
            'created_at'
        )->paginate(5);

        return response()->json($users);
    }

    // Delete a user
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }
}
