<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Models\Settings\SystemSetting;
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
     * Display the specified resource.
     */
    public function show(SystemSetting $systemSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateSystem(SystemSettingRequest $request, SystemSetting $systemSetting)
    {

        $validated = $request->validated();

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $oldImagePath = public_path('storage/setting_logos/' . basename($systemSetting->logo));

            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
            $validated['logo'] = $request['logo']->store('setting_logos/', 'public');
        }
        if (!isset($request['logo'])) {
            $oldImagePath = public_path('storage/setting_logos/' . basename($systemSetting->logo));

            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
            $validated['logo'] = $logoPath;
        }
        if (is_string($request['logo'])) {
            // return ($systemSetting->logo);
            $validated['logo'] = $systemSetting->logo;
        }
        $systemSetting->update($validated);

        return SystemSettingResource::make($systemSetting);


        // return response()->json(['success' => 'Setting updated successfully']);
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SystemSetting $systemSetting)
    {
        //
    }
}
