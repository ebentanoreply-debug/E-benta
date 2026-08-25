<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PasswordResetToken;
use App\Models\Notification;
use App\Models\UserEmailChangeRequest;
use App\Services\AuditLogger;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use App\Mail\PasswordResetMail;
use App\Mail\EmailChangeVerificationMail;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Display the registration view.
     */
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:seller,buyer'],
            'business_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'business_name' => $request->business_name,
            'phone' => $request->phone,
            'is_verified' => $request->role === 'seller', // Sellers are auto-verified
        ]);

        event(new Registered($user));

        // Notify all admins about new registration
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            if ($user->role === 'buyer') {
                Notification::notify(
                    $admin,
                    'new_buyer_registration',
                    'New Buyer Registration',
                    "{$user->name} ({$user->email}) has registered as a buyer and is pending verification.",
                    [
                        'user_id' => $user->id,
                        'user_name' => $user->name,
                        'user_email' => $user->email,
                    ]
                );
            } elseif ($user->role === 'seller') {
                Notification::notify(
                    $admin,
                    'new_seller_registration',
                    'New Seller Registered',
                    "{$user->name} ({$user->email}) has registered as a seller.",
                    [
                        'user_id' => $user->id,
                        'user_name' => $user->name,
                        'user_email' => $user->email,
                        'business_name' => $user->business_name,
                    ]
                );
            }
        }

        // Notify seller that they registered successfully
        if ($user->role === 'seller') {
            Notification::notify(
                $user,
                'seller_registration_success',
                'Welcome to E-Benta! 🎉',
                'Your seller account has been created. Start creating listings to reach buyers.',
                ['user_id' => $user->id]
            );
        }

        Auth::login($user);
        $request->session()->put('auth_via_google', false);

        // Log registration
        AuditLogger::log(
            action: 'register',
            description: "User registered as {$user->role}",
            modelType: 'User',
            modelId: $user->id,
            newValues: ['email' => $user->email, 'role' => $user->role]
        );

        // Redirect based on role
        if ($user->role === 'seller') {
            return redirect()->route('seller.dashboard')
                ->with('success', 'Registration successful! Create your first listing.');
        } else {
            return redirect()->route('buyer.dashboard')
                ->with('info', 'Registration successful! Your account is pending admin verification.');
        }
    }

    /**
     * Display the login view.
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming login request.
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();
            $request->session()->put('auth_via_google', false);

            $user = Auth::user();

            if ($user->isBanned() || $user->isSuspended()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->withErrors([
                    'email' => $user->isBanned()
                        ? 'This account has been banned.'
                        : 'This account is currently suspended.',
                ]);
            }

            // Log login
            AuditLogger::logLogin("User {$user->name} logged in from {$request->ip()}");

            // Redirect based on role
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isSeller()) {
                return redirect()->route('seller.dashboard');
            } else {
                return redirect()->route('buyer.dashboard');
            }
        }

        $user = User::where('email', $request->email)->first();

        if ($user && $user->oauth_provider === 'google') {
            return back()->withErrors([
                'email' => 'This account is linked with Google. Please sign in with Google, or use Forgot Password to set a local password.',
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Handle an outgoing authenticated request.
     */
    public function logout(Request $request): RedirectResponse
    {
        $user = Auth::user();
        
        // Log logout before clearing session
        if ($user) {
            AuditLogger::logLogout("User {$user->name} logged out");
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logged out successfully');
    }

    /**
     * Show user profile.
     */
    public function showProfile(User $user = null): View
    {
        $user = $user ?? Auth::user();

        return view('auth.profile', compact('user'));
    }

    /**
     * Update user profile.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'business_name' => ['nullable', 'string', 'max:255'],
            'business_description' => ['nullable', 'string', 'max:1000'],
        ]);

        $user->update($validated);

        return redirect()->back()
            ->with('success', 'Profile updated successfully');
    }

    /**
     * Show change password form.
     */
    public function showChangePasswordForm(): View
    {
        $user = Auth::user();
        $canSkipCurrentPassword = $user->oauth_provider === 'google' && session('auth_via_google', false);

        return view('auth.change-password', compact('canSkipCurrentPassword'));
    }

    /**
     * Handle password change.
     */
    public function changePassword(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $canSkipCurrentPassword = $user->oauth_provider === 'google' && $request->session()->get('auth_via_google', false);

        if ($canSkipCurrentPassword) {
            $request->validate([
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
        } else {
            $request->validate([
                'current_password' => ['required', 'current_password'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // User has set a local password and can now use regular login too.
        $request->session()->put('auth_via_google', false);

        return redirect()->back()
            ->with('success', $canSkipCurrentPassword
                ? 'Password set successfully. You can now sign in using email and password as well.'
                : 'Password changed successfully');
    }

    /**
     * Show forgot password form.
     */
    public function showForgotPasswordForm(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle forgot password request and send 6-digit OTP code.
     */
    public function sendForgotPasswordEmail(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Generate 6-digit numeric OTP code
            $code = sprintf("%06d", random_int(100000, 999999));

            PasswordResetToken::where('user_id', $user->id)
                ->where('used', false)
                ->delete();

            PasswordResetToken::create([
                'user_id' => $user->id,
                'email' => $user->email,
                'token' => $code,
                'expires_at' => now()->addMinutes(15),
                'used' => false,
            ]);

            try {
                Mail::to($user->email)->send(new PasswordResetMail($user, $code));
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Password reset mail failed: ' . $e->getMessage());
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['email' => 'Failed to send reset code email. Please check your mail configuration or try again later.']);
            }
        }

        return redirect()->route('password.reset', ['email' => $request->email])
            ->with('success', 'If an account matches that email, a 6-digit verification code has been sent.');
    }

    /**
     * Show reset password form.
     */
    public function showResetPasswordForm(Request $request): View
    {
        $email = $request->email ?? session('reset_email', '');
        $code = $request->code ?? $request->route('token') ?? $request->token ?? '';

        return view('auth.reset-password', compact('email', 'code'));
    }

    /**
     * Handle password reset with 6-digit OTP code.
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'code' => ['required', 'string', 'size:6'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'code.required' => 'Please enter the 6-digit verification code sent to your email.',
            'code.size' => 'The verification code must be exactly 6 digits.',
        ]);

        $resetToken = PasswordResetToken::where('email', $request->email)
            ->where('token', $request->code)
            ->where('used', false)
            ->latest()
            ->first();

        $isValidToken = $resetToken
            && $resetToken->expires_at
            && $resetToken->expires_at->isFuture();

        if (!$isValidToken) {
            return redirect()->back()
                ->withInput($request->only('email', 'code'))
                ->withErrors(['code' => 'The verification code is invalid or has expired. Please request a new one.']);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->route('password.forgot')
                ->withErrors(['email' => 'No account found with this email address.']);
        }

        DB::transaction(function () use ($user, $request, $resetToken): void {
            $user->update([
                'password' => Hash::make($request->password),
            ]);

            $resetToken->update(['used' => true]);
        });

        // Log the password reset
        AuditLogger::log(
            action: 'password_reset',
            description: "User {$user->name} successfully reset password using 6-digit verification code",
            modelType: 'User',
            modelId: $user->id
        );

        return redirect()->route('login')
            ->with('success', 'Your password has been reset successfully! Please log in with your new password.');
    }

    /**
     * Show email change request form.
     */
    public function showEmailChangeRequestForm(): View
    {
        return view('auth.email-change-request');
    }

    /**
     * Handle email change request.
     */
    public function sendEmailChangeRequest(Request $request): RedirectResponse
    {
        $user = Auth::user();

        // Check if new email is same as current
        if (strtolower($request->new_email) === strtolower($user->email)) {
            return redirect()->back()
                ->withErrors(['new_email' => 'The new email must be different from your current email.'])
                ->withInput();
        }

        $request->validate([
            'new_email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'current_password'],
        ], [
            'new_email.unique' => 'This email address is already registered.',
            'password.current_password' => 'The password you entered is incorrect.',
        ]);

        $token = bin2hex(random_bytes(32));

        UserEmailChangeRequest::where('user_id', $user->id)
            ->where('used', false)
            ->delete();

        $emailChangeRequest = UserEmailChangeRequest::create([
            'user_id' => $user->id,
            'token' => $token,
            'new_email' => $request->new_email,
            'expires_at' => now()->addHour(),
            'used' => false,
        ]);

        $verifyLink = route('email.change.verify', ['token' => $emailChangeRequest->token]);
        Mail::to($emailChangeRequest->new_email)->send(
            new EmailChangeVerificationMail($user, $emailChangeRequest->new_email, $verifyLink)
        );

        return redirect()->route('settings')
            ->with('success', 'A verification link has been sent to your new email address.');
    }

    /**
     * Show email change verification form.
     */
    public function showVerifyEmailChangeForm(Request $request)
    {
        $token = $request->route('token') ?? $request->token;
        $user = Auth::user();

        $emailChangeRequest = UserEmailChangeRequest::where('user_id', $user?->id)
            ->where('used', false)
            ->latest('id')
            ->first();

        // Check if user has a pending email change
        if (!$user || !$emailChangeRequest) {
            return redirect()->route('profile')
                ->withErrors(['token' => 'No pending email change request found.']);
        }

        if (!hash_equals((string) $emailChangeRequest->token, (string) $token)) {
            return redirect()->route('profile')
                ->withErrors(['token' => 'Invalid email change token.']);
        }

        // Check if token has expired
        if ($emailChangeRequest->expires_at < now()) {
            $emailChangeRequest->delete();

            return redirect()->route('profile')
                ->withErrors(['token' => 'Email change verification link has expired. Please try again.']);
        }

        $new_email = $emailChangeRequest->new_email;

        return view('auth.email-change-verify', compact('token', 'new_email'));
    }

    /**
     * Handle email change verification.
     */
    public function verifyEmailChange(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required', 'string'],
        ]);

        $user = Auth::user();

        $emailChangeRequest = UserEmailChangeRequest::where('user_id', $user->id)
            ->where('token', $request->token)
            ->where('used', false)
            ->latest('id')
            ->first();

        if (!$emailChangeRequest || $emailChangeRequest->expires_at < now()) {
            return redirect()->route('profile')
                ->withErrors(['token' => 'The email change token is invalid or has expired.']);
        }

        $newEmail = $emailChangeRequest->new_email;

        DB::transaction(function () use ($user, $newEmail, $emailChangeRequest): void {
            $user->update(['email' => $newEmail]);

            $emailChangeRequest->update(['used' => true]);

            UserEmailChangeRequest::where('user_id', $user->id)
                ->where('used', false)
                ->where('id', '!=', $emailChangeRequest->id)
                ->delete();
        });

        return redirect()->route('profile')
            ->with('success', 'Your email has been successfully changed to ' . $newEmail . '. You may need to login again with your new email.');
    }
}
