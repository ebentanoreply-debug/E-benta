<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EmailVerification;
use App\Mail\VerificationCodeMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class EmailVerificationController extends Controller
{
    /**
     * Show the email verification page
     */
    public function show(): View
    {
        // Check if this is a new user from Google registration
        $pendingUserId = session('pending_verification_user_id');
        
        if ($pendingUserId) {
            // New user from OAuth - get user without requiring auth
            $user = User::find($pendingUserId);
            if (!$user) {
                return redirect('/login')->with('error', 'Session expired. Please try again.');
            }
            return view('auth.verify-email', ['user' => $user]);
        }

        // Existing logged-in user
        $user = Auth::user();
        if (!$user) {
            return redirect('/login')->with('error', 'Please log in first.');
        }

        // Redirect if already verified
        if ($user->email_verified_at) {
            return redirect('/dashboard')->with('info', 'Your email is already verified.');
        }

        return view('auth.verify-email', ['user' => $user]);
    }

    /**
     * Send verification code to user email
     */
    public function send(): RedirectResponse
    {
        // Check if this is a new user from Google registration
        $pendingUserId = session('pending_verification_user_id');
        $user = null;

        if ($pendingUserId) {
            $user = User::find($pendingUserId);
            if (!$user) {
                return redirect('/login')->with('error', 'Session expired. Please try again.');
            }
        } else {
            $user = Auth::user();
            if (!$user) {
                return redirect('/login')->with('error', 'Please log in first.');
            }
        }

        // Check if user is already verified
        if ($user->email_verified_at) {
            return redirect('/dashboard')->with('info', 'Your email is already verified.');
        }

        // Delete any existing unused codes
        EmailVerification::where('user_id', $user->id)
            ->where('used', false)
            ->delete();

        // Generate 6-digit code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Create verification record (10 minutes expiration)
        EmailVerification::create([
            'user_id' => $user->id,
            'code' => $code,
            'expires_at' => now()->addMinutes(10),
        ]);

        // Send email
        Mail::to($user->email)->send(new VerificationCodeMail($user, $code));

        return back()->with('success', 'Verification code sent to ' . $user->email);
    }

    /**
     * Verify the email with code
     */
    public function verify(): RedirectResponse
    {
        // Check if this is a new user from Google registration
        $pendingUserId = session('pending_verification_user_id');
        $user = null;

        if ($pendingUserId) {
            $user = User::find($pendingUserId);
            if (!$user) {
                return redirect('/login')->with('error', 'Session expired. Please try again.');
            }
        } else {
            $user = Auth::user();
            if (!$user) {
                return redirect('/login')->with('error', 'Please log in first.');
            }
        }

        // Check if already verified
        if ($user->email_verified_at) {
            return redirect('/dashboard')->with('info', 'Your email is already verified.');
        }

        // Validate input
        $validated = request()->validate([
            'code' => 'required|string|size:6|regex:/^[0-9]+$/',
        ], [
            'code.required' => 'Verification code is required',
            'code.size' => 'Code must be 6 digits',
            'code.regex' => 'Code must contain only numbers',
        ]);

        // Find matching verification record
        $verification = EmailVerification::where('user_id', $user->id)
            ->where('code', $validated['code'])
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$verification) {
            return back()->withErrors(['code' => 'Invalid or expired verification code']);
        }

        // Mark code as used
        $verification->update(['used' => true]);

        // Mark email as verified
        $user->update([
            'email_verified_at' => now(),
        ]);

        // Log the action
        \App\Services\AuditLogger::log(
            action: 'email_verified',
            description: 'User verified their email address with 6-digit code',
            modelType: 'User',
            modelId: $user->id
        );

        // Store user in pending set password session
        session([
            'pending_set_password_user_id' => $user->id,
        ]);
        session()->forget('pending_verification_user_id');

        return redirect()->route('register.set-password')
            ->with('success', 'Email confirmed! Now please set a password for your account.');
    }

    /**
     * Show Set Password form after registration email verification.
     */
    public function showSetPasswordForm(): View|RedirectResponse
    {
        $userId = session('pending_set_password_user_id');
        if (!$userId) {
            return redirect('/login')->with('error', 'Session expired. Please sign in or register.');
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect('/login')->with('error', 'User not found.');
        }

        return view('auth.register-set-password', compact('user'));
    }

    /**
     * Save Password and complete registration.
     */
    public function savePasswordAndComplete(\Illuminate\Http\Request $request): RedirectResponse
    {
        $userId = session('pending_set_password_user_id');
        if (!$userId) {
            return redirect('/login')->with('error', 'Session expired. Please sign in or register.');
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect('/login')->with('error', 'User not found.');
        }

        $request->validate([
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'is_verified' => $user->role === 'seller' ? true : $user->is_verified,
        ]);

        // Notify admins about verified registration
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            \App\Models\Notification::notify(
                $admin,
                'user_registration_completed',
                'New Registered User',
                "{$user->name} ({$user->email}) has completed registration as a {$user->role}.",
                [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'user_email' => $user->email,
                    'role' => $user->role,
                ]
            );
        }

        // Login user
        Auth::login($user);
        session()->forget('pending_set_password_user_id');

        if ($user->role === 'seller') {
            return redirect()->route('seller.dashboard')
                ->with('success', 'Registration complete! Welcome to E-Benta.');
        } elseif ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Welcome to Admin Dashboard!');
        } else {
            return redirect()->route('buyer.dashboard')
                ->with('success', 'Registration complete! Welcome to E-Benta.');
        }
    }

    /**
     * Resend verification code
     */
    public function resend(): RedirectResponse
    {
        // Check if this is a new user from Google registration
        $pendingUserId = session('pending_verification_user_id');
        $user = null;

        if ($pendingUserId) {
            $user = User::find($pendingUserId);
            if (!$user) {
                return redirect('/login')->with('error', 'Session expired. Please try again.');
            }
        } else {
            $user = Auth::user();
            if (!$user) {
                return redirect('/login')->with('error', 'Please log in first.');
            }
        }

        // Check if already verified
        if ($user->email_verified_at) {
            return redirect('/dashboard')->with('info', 'Your email is already verified.');
        }

        // Check rate limiting (can't request more than once per minute)
        $recentCode = EmailVerification::where('user_id', $user->id)
            ->where('created_at', '>', now()->subMinute())
            ->first();

        if ($recentCode) {
            return back()->withErrors(['code' => 'Please wait a moment before requesting another code']);
        }

        // Delete existing codes
        EmailVerification::where('user_id', $user->id)
            ->where('used', false)
            ->delete();

        // Generate new code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Create verification record
        EmailVerification::create([
            'user_id' => $user->id,
            'code' => $code,
            'expires_at' => now()->addMinutes(10),
        ]);

        // Send email
        Mail::to($user->email)->send(new VerificationCodeMail($user, $code));

        return back()->with('success', 'New verification code sent to ' . $user->email);
    }
}
