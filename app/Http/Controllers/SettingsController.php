<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function updateNotifications(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email_notifications' => ['required', 'boolean'],
            'sms_notifications' => ['required', 'boolean'],
            'marketing_updates' => ['required', 'boolean'],
        ]);

        $request->user()->update($validated);

        return redirect()->back()->with('success', 'Notification preferences updated successfully.');
    }

    public function updatePrivacy(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'profile_visibility' => ['required', 'in:public,private'],
        ]);

        $request->user()->update($validated);

        return redirect()->back()->with('success', 'Privacy settings updated successfully.');
    }
}
