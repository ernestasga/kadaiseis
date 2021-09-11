<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Settings;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $settings = Settings::all();
        return view('admin.settings', compact('settings'));
    }
    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
            'value' => 'required'
        ]);
        $setting = Settings::findOrFail($validated['id']);
        $res = $setting->update([
            'value' => $validated['value']
        ]);

        if($res){
            return response()->json([
                'success' => 'Setting updated successfully',
            ]);
        }
        return response()->json([
            'error' => 'Failed to update setting'
        ]);
    }
}
