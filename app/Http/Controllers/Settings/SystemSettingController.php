<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Settings\SystemSetting;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Settings\SystemSettingRequest;
use App\Http\Resources\Settings\SystemSettingResource;

class SystemSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $systemSetting = SystemSetting::find(1);
        return SystemSettingResource::make($systemSetting);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SystemSettingRequest $request)
    {
        // $validated = $request->validated();

        // if ($request->hasFile('logo')) {
        //     $imagePath = $request->file('logo')->store('images', 'public');
        //     $validated['logo'] = $imagePath;
        // }

        // // Create the listing with the validated data
        // SystemSetting::create($validated);

        // return response()->json(['success' => 'Sytem information inserted successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(SystemSetting $systemSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateSystem(Request $request, $id)
    {
        $systemSetting = SystemSetting::find($id);

        $validated = $request->validate(
            [
                'email' => 'sometimes|string|email|unique:system_settings,email|max:192',
                'phone' => 'sometimes|string|max:64',
                // 'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif', // adjust validation rules for image upload
                'address' => 'sometimes|string',
                'companyName' => 'sometimes|string',
            ]
        );

        // if ($request->hasFile('logo')) {
        //     $imagePath = $request->file('logo')->store('images', 'public');
        //     $validated['logo'] = $imagePath;
        // }

        // Update the listing with the validated data
        $systemSetting->update($validated);

        // return response()->json(['success' => 'System information updated successfully']);
        return SystemSettingResource::make($systemSetting);
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SystemSetting $systemSetting)
    {
        //
    }
}
