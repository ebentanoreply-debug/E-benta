<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SettingsController extends Controller
{
    /**
     * Show the settings page with user stats.
     */
    public function index(): View
    {
        $user = Auth::user();
        $stats = [];

        if ($user->isSeller()) {
            $stats = [
                'total_listings' => $user->listings()->count(),
                'active_listings' => $user->listings()->where('status', 'available')->count(),
                'sold_items' => $user->listings()->where('status', 'matched')->orWhere('status', 'processed')->count(),
                'co2_saved' => round($user->total_co2_saved ?? 0, 2),
                'items_processed' => $user->items_processed ?? 0,
            ];
        }

        return view('settings.index', compact('stats'));
    }

    /**
     * Update notification preferences.
     */
    public function updateNotifications(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email_notifications' => ['required', 'boolean'],
            'sms_notifications' => ['required', 'boolean'],
            'marketing_updates' => ['required', 'boolean'],
            'notify_new_offer' => ['required', 'boolean'],
            'notify_transaction_complete' => ['required', 'boolean'],
            'notify_new_message' => ['required', 'boolean'],
            'notify_admin_updates' => ['required', 'boolean'],
        ]);

        $request->user()->update($validated);

        return redirect()->back()->with('success', 'Notification preferences updated successfully.');
    }

    /**
     * Update privacy settings.
     */
    public function updatePrivacy(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'profile_visibility' => ['required', 'in:public,private'],
        ]);

        $request->user()->update($validated);

        return redirect()->back()->with('success', 'Privacy settings updated successfully.');
    }

    /**
     * Update payment preferences.
     */
    public function updatePayments(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'gcash_number' => ['nullable', 'string', 'regex:/^(09|\+639)\d{9}$/'],
            'bank_name' => ['nullable', 'string', 'max:100'],
            'bank_account_number' => ['nullable', 'string', 'max:50'],
        ]);

        $request->user()->update($validated);

        return redirect()->back()->with('success', 'Payment preferences updated successfully.');
    }

    /**
     * Update seller profile settings.
     */
    public function updateSellerProfile(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'business_name' => ['nullable', 'string', 'max:255'],
            'business_description' => ['nullable', 'string', 'max:1000'],
            'preferred_action' => ['nullable', 'in:sell,recycle'],
            'address_city' => ['nullable', 'string', 'max:100'],
            'address_province' => ['nullable', 'string', 'max:100'],
        ]);

        $request->user()->update($validated);

        return redirect()->back()->with('success', 'Seller profile updated successfully.');
    }

    /**
     * Submit government ID verification documents (Buyer & Seller).
     */
    public function submitIdVerification(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_type' => ['required', 'string', 'max:100'],
            'id_number' => ['required', 'string', 'max:100'],
            'id_photo' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'id_selfie' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
        ]);

        $user = $request->user();

        $idPhotoUrl = null;
        if ($request->hasFile('id_photo')) {
            $uploaded = \App\Services\CloudflareStorageService::upload($request->file('id_photo'), 'verifications');
            $idPhotoUrl = \App\Services\CloudflareStorageService::url($uploaded);
        }

        $idSelfieUrl = null;
        if ($request->hasFile('id_selfie')) {
            $uploadedSelfie = \App\Services\CloudflareStorageService::upload($request->file('id_selfie'), 'verifications');
            $idSelfieUrl = \App\Services\CloudflareStorageService::url($uploadedSelfie);
        }

        $user->update([
            'id_type' => $validated['id_type'],
            'id_number' => $validated['id_number'],
            'id_photo_url' => $idPhotoUrl,
            'id_selfie_url' => $idSelfieUrl,
            'id_verification_status' => 'pending',
            'id_submitted_at' => now(),
            'id_rejection_reason' => null,
        ]);

        \App\Services\AuditLogger::log(
            action: 'id_verification_submitted',
            description: "User {$user->name} submitted ID verification documents ({$validated['id_type']})",
            modelType: 'User',
            modelId: $user->id
        );

        return redirect()->back()->with('success', 'Your Valid ID has been submitted for review. Our team will verify your account shortly.');
    }

    /**
     * Update general preferences.
     */
    public function updatePreferences(Request $request): RedirectResponse
    {
        // Preferences like dark mode are saved client-side (localStorage).
        // If we add server-side prefs later, they go here.
        return redirect()->back()->with('success', 'Preferences saved.');
    }
}
