<?php

namespace App\Http\Controllers\Peoples;

use App\Models\Peoples\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Peoples\UserRequest;
use App\Http\Resources\Peoples\UserResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        $users = User::query()->search($search);

        $users = $perPage ? $users->latest()->paginate($perPage) : $users->latest()->get();
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $validated['image']->store('user_images/', 'public');
        }

        User::create($validated);

        return response()->json(['success' => 'User inserted successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return UserResource::make($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        $validated = $request->validated();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $oldImagePath = public_path('storage/user_images/' . basename($user->image));

            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
            $validated['image'] = $request['image']->store('user_images/', 'public');
        }
        if (!isset($request['image'])) {
            $oldImagePath = public_path('storage/user_images/' . basename($user->image));

            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
            $validated['image'] = $imagePath;
        }
        if (is_string($request['image'])) {
            $validated['image'] = $user->image;
        }
        $user->update($validated);

        return response()->json(['success' => 'User updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $imagePath = public_path('storage/user_images/' . basename($user->image));
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }
        $user->delete();
        return response()->noContent();
    }

    public function bulkDelete(Request $request)
    {
        $users = $request->input('userIds');
        User::destroy($users);
        return response()->json(['success', 'Users deleted successfully']);
    }
}
