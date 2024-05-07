<?php

namespace App\Http\Controllers\Peoples;

use App\Models\Peoples\User;
use App\Traits\ImageManipulation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Peoples\UserRequest;
use App\Http\Resources\Peoples\UserResource;

class UserController extends Controller
{
    use ImageManipulation;
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

        $request->hasFile('image') ? $this->storeImage($request, $validated, 'user_images') : null;

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
    public function updateUser(UserRequest $request, User $user)
    {
        $validated = $request->validated();

        $this->updateImage($user, $request, $validated, 'user_images');

        $user->update($validated);

        return response()->json(['success' => 'User updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->deleteImage($user, 'material_images');
        $user->delete();
        return response()->noContent();
    }

    public function switchUser(Request $request, User $user)
    {
        // HERE WE SWITCH THE STATUS OF USER
        $user->update($request->validate(['status' => 'boolean']));
        // dd($user->status);
        return new UserResource($user);
    }

    public function bulkDelete(Request $request)
    {
        $users = $request->input('userIds');
        User::destroy($users);
        return response()->json(['success', 'Users deleted successfully']);
    }

    

}
