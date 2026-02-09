<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update the settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string|max:500',
            'usd_exchange_rate' => 'required|numeric|min:1',
        ]);

        // Update text fields
        $textFields = ['company_name', 'company_address', 'usd_exchange_rate'];
        foreach ($textFields as $field) {
            Setting::updateOrCreate(
                ['key' => $field],
                [
                    'value' => $request->$field,
                    'type' => $field === 'usd_exchange_rate' ? 'number' : 'text',
                ]
            );
        }

        // Handle company logo upload
        if ($request->hasFile('company_logo')) {
            $request->validate([
                'company_logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $logo = $request->file('company_logo');
            $logoName = 'company_logo_' . time() . '.' . $logo->getClientOriginalExtension();
            $logoPath = 'uploads/settings/';

            // Create directory if it doesn't exist
            if (!File::exists(public_path($logoPath))) {
                File::makeDirectory(public_path($logoPath), 0755, true);
            }

            // Delete old logo if exists
            $oldLogo = Setting::where('key', 'company_logo')->value('value');
            if ($oldLogo && File::exists(public_path($oldLogo))) {
                File::delete(public_path($oldLogo));
            }

            $logo->move(public_path($logoPath), $logoName);
            
            Setting::updateOrCreate(
                ['key' => 'company_logo'],
                [
                    'value' => $logoPath . $logoName,
                    'type' => 'file',
                ]
            );
        }

        // Handle signature upload
        if ($request->hasFile('hr_finance_signature')) {
            $request->validate([
                'hr_finance_signature' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $signature = $request->file('hr_finance_signature');
            $signatureName = 'signature_' . time() . '.' . $signature->getClientOriginalExtension();
            $signaturePath = 'uploads/settings/';

            // Create directory if it doesn't exist
            if (!File::exists(public_path($signaturePath))) {
                File::makeDirectory(public_path($signaturePath), 0755, true);
            }

            // Delete old signature if exists
            $oldSignature = Setting::where('key', 'hr_finance_signature')->value('value');
            if ($oldSignature && File::exists(public_path($oldSignature))) {
                File::delete(public_path($oldSignature));
            }

            $signature->move(public_path($signaturePath), $signatureName);
            
            Setting::updateOrCreate(
                ['key' => 'hr_finance_signature'],
                [
                    'value' => $signaturePath . $signatureName,
                    'type' => 'file',
                ]
            );
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully!');
    }
}
