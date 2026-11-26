<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\World;
use App\Models\Activity;
use App\Models\User;
use App\Models\Question;
use Illuminate\Http\Request;

class WorldManagementController extends Controller
{
    public function statistics()
    {
        return response()->json([
            'total_users' => User::count(),
            'total_worlds' => World::count(),
            'total_activities' => Activity::count(),
            'total_questions' => Question::count(),
        ]);
    }
public function index(Request $request)
{
    $query = World::query();

    if ($request->filled('search')) {
        $search = $request->search;

        $query->where('name', 'like', "%{$search}%");
    }

    $worlds = $query->withCount('activities')->paginate(5);

    return response()->json($worlds);
}
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255', 'unique:worlds,name'],
    ]);

    $world = World::create($validated);

    return response()->json([
        'message' => 'World created successfully',
        'world' => $world,
    ], 201);
}

public function update(Request $request, $id)
{
    $world = World::findOrFail($id);

    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255', 'unique:worlds,name,' . $world->id],
    ]);

    $world->update($validated);

    return response()->json([
        'message' => 'World updated successfully',
        'world' => $world,
    ]);
}
public function toggleStatus($id)
{
    $world = World::findOrFail($id);

    $world->is_active = !$world->is_active;
    $world->save();

    return response()->json([
        'message' => $world->is_active
            ? 'World activated successfully'
            : 'World deactivated successfully',
        'world' => $world,
    ]);
}

public function destroy($id)
{
    $world = World::findOrFail($id);

    $world->delete();

    return response()->json([
        'message' => 'World deleted successfully'
    ]);
}
}