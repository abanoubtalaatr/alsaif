<?php

namespace App\Http\Controllers\Api;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return response()->json(['setting' => $setting]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Use firstOrCreate to get or create a setting record
        $setting = Setting::firstOrCreate(
            [], // Attributes to match (empty to get first or create new)
            ['email' => $request->email] // Default values for new record
        );

        // Update email if the record already existed
        if ($setting->wasRecentlyCreated === false) {
            $setting->email = $request->email;
            $setting->save();
        }

        return response()->json(['message' => 'Setting updated successfully']);
    }
}