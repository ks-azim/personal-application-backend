<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function getSettings()
    {
        try {
            $settings = Setting::where('id', 1)->first();

            return response()->json([
                'status'   => 200,
                'data'     => $settings
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status'   => 500,
                'message'  => $e
            ]);
        }
    }

    public function updateSettings(Request $request)
    {
        try {
            Setting::where('id', 1)->update([
                'logo'       => $request->logo, 
                'brand_name' => $request->brand_name, 
                'phone'      => $request->phone, 
                'email'      => $request->email, 
                'address'    => $request->address, 
                'map'        => $request->map
            ]);
    
            return response()->json([
                'status'   => 200,
                'message'  => 'Settings Updated Successfully !'
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status'   => 500,
                'message'  => $e
            ]);
        }
    }
}
