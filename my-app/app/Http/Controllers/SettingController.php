<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Currency; // কারেন্সি মডেল ইনক্লুড করা হলো
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // ফাইল আপলোডের জন্য

class SettingController extends Controller
{
    /**
     * Display the settings form (equivalent to show/edit).
     */
    public function index()
    {
        // নিশ্চিত করা হলো যে ডেটাবেসে অন্তত একটি সেটিংস রো আছে
        $settings = Setting::getSettings();
        $currencies = Currency::all();

        return view('pages.settings.index', compact('settings', 'currencies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $settings = Setting::getSettings();

        $validatedData = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'company_email' => 'nullable|email|max:255',
            'company_phone' => 'nullable|string|max:20',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // ইমেজ ভ্যালিডেশন
            'default_currency_id' => 'nullable|exists:currencies,id',
            'default_currency_position' => 'required|in:prefix,suffix',
            'notification_email' => 'nullable|email|max:255',
            'footer_text' => 'nullable|string|max:255',
            'company_address' => 'nullable|string',
        ]);

        if ($request->hasFile('site_logo')) {
            // পুরাতন লোগো ডিলিট করা
            if ($settings->site_logo && Storage::disk('public')->exists($settings->site_logo)) {
                Storage::disk('public')->delete($settings->site_logo);
            }
            // নতুন লোগো আপলোড করা
            $validatedData['site_logo'] = $request->file('site_logo')->store('logos', 'public');
        } else {
            // যদি লোগো আপলোড না হয়, তবে ডেটা থেকে site_logo সরিয়ে দেওয়া
            unset($validatedData['site_logo']);
        }

        $settings->update($validatedData);

        return redirect()->route('settings.index')
                         ->with('success', 'System settings updated successfully.');
    }

    // যেহেতু সেটিংস একটি একক ইনস্ট্যান্স, তাই অন্যান্য রিসোর্স মেথড (store, create, destroy) এর প্রয়োজন নেই।
}
