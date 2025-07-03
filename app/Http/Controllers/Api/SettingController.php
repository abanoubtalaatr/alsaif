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

        $setting = Setting::first();
        $setting->email = $request->email;
        $setting->save();

        return response()->json(['message' => 'Setting updated successfully']);
    }
}
