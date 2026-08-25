<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use App\Models\EmailVerification;
use App\Services\AuditLogger;
use App\Mail\VerificationCodeMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirect(): mixed
    {
        // Ensure we're starting fresh - logout any existing session
        if (Auth::check()) {
            Auth::logout();
            session()->regenerate();
        }

        // Force Google to show account picker (useful for logging in with different accounts)
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function callback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Exception $e) {
            return redirect('/login')->with('error', 'Failed to authenticate with Google. Please try again.');
        }

        // Check if user already exists with this Google ID
        $user = User::where('google_id', $googleUser->getId())->first();

        if ($user) {
            // Existing user - auto-login
            Auth::login($user);
            request()->session()->regenerate();
            request()->session()->put('auth_via_google', true);

            // Log the login activity
            AuditLogger::log(
                action: 'login',
                description: 'User logged in via Google OAuth',
                modelType: 'User',
                modelId: $user->id
            );

            return redirect('/')->with('success', 'Welcome back!');
        }

        // Check if user exists with this email
        $existingUser = User::where('email', $googleUser->getEmail())->first();

        if ($existingUser) {
            // Link Google account to existing user
            $existingUser->update([
                'google_id' => $googleUser->getId(),
                'oauth_provider' => 'google',
            ]);

            Auth::login($existingUser);
            request()->session()->regenerate();
            request()->session()->put('auth_via_google', true);

            AuditLogger::log(
                action: 'update',
                description: 'Google OAuth linked to existing account',
                modelType: 'User',
                modelId: $existingUser->id,
                newValues: ['oauth_provider' => 'google']
            );

            return redirect('/')->with('success', 'Google account linked successfully!');
        }

        // New user - show confirmation screen
        session([
            'google_user' => [
                'id' => $googleUser->getId(),
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'avatar' => $googleUser->getAvatar(),
            ],
            'google_user_hash' => hash('sha256', json_encode([
                'id' => $googleUser->getId(),
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'avatar' => $googleUser->getAvatar(),
            ])),
        ]);

        return redirect('/auth/google/confirm');
    }

    /**
     * Show confirmation screen for new Google users
     */
    public function showConfirmation(): \Illuminate\View\View
    {
        if (Auth::check()) {
            return redirect('/');
        }

        $googleUser = session('google_user');
        $googleUserHash = session('google_user_hash');

        if (!$googleUser || !$googleUserHash) {
            return redirect('/login')->with('error', 'Session expired. Please try again.');
        }

        if (hash('sha256', json_encode($googleUser)) !== $googleUserHash) {
            session()->flush();
            return redirect('/login')->with('error', 'Invalid session. Please try again.');
        }

        return view('auth.google-confirm', ['user' => $googleUser]);
    }

    /**
     * Confirm Google user and proceed to role selection
     */
    public function confirmRegistration(): RedirectResponse
    {
        if (Auth::check()) {
            return redirect('/');
        }

        $googleUser = session('google_user');
        $googleUserHash = session('google_user_hash');

        if (!$googleUser || !$googleUserHash) {
            return redirect('/login')->with('error', 'Session expired. Please try again.');
        }

        if (hash('sha256', json_encode($googleUser)) !== $googleUserHash) {
            session()->flush();
            return redirect('/login')->with('error', 'Invalid session. Please try again.');
        }

        return redirect('/auth/google/select-role');
    }

    /**
     * Show role selection form for new Google users
     */
    public function showSelectRole()
    {
        // Prevent already authenticated users from accessing this
        if (Auth::check()) {
            return redirect('/');
        }

        $googleUser = session('google_user');
        $googleUserHash = session('google_user_hash');

        if (!$googleUser || !$googleUserHash) {
            return redirect('/login')->with('error', 'Session expired. Please try again.');
        }

        // Verify session data integrity
        if (hash('sha256', json_encode($googleUser)) !== $googleUserHash) {
            session()->flush();
            return redirect('/login')->with('error', 'Invalid session. Please try again.');
        }

        return view('auth.role-selection');
    }

    /**
     * Complete registration with selected role
     */
    public function completeRegistration(): RedirectResponse
    {
        // Prevent already authenticated users from accessing this
        if (Auth::check()) {
            return redirect('/');
        }

        $googleUser = session('google_user');
        $googleUserHash = session('google_user_hash');

        if (!$googleUser || !$googleUserHash) {
            return redirect('/login')->with('error', 'Session expired. Please try again.');
        }

        // Verify session data integrity
        if (hash('sha256', json_encode($googleUser)) !== $googleUserHash) {
            session()->flush();
            return redirect('/login')->with('error', 'Invalid session. Please try again.');
        }

        // Validate role and password
        $validated = request()->validate([
            'role' => ['required', 'in:seller,buyer'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'agree_terms' => ['required', 'accepted'],
            'business_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
        ], [
            'agree_terms.required' => 'You must agree to the Terms of Service and Privacy Policy',
            'agree_terms.accepted' => 'You must agree to the Terms of Service and Privacy Policy',
            'role.required' => 'Please select a role (Seller or Buyer)',
            'password.required' => 'Please create a password for your account',
            'password.min' => 'Password must be at least 8 characters long',
            'password.confirmed' => 'Password confirmation does not match',
        ]);

        // Check if user already exists with this email
        $existingUser = User::where('email', $googleUser['email'])->first();

        if ($existingUser) {
            // User already exists - link Google and set password
            $updateData = [
                'google_id' => $googleUser['id'],
                'oauth_provider' => 'google',
                'password' => Hash::make($validated['password']),
            ];
            if (!$existingUser->email_verified_at) {
                $updateData['email_verified_at'] = now();
            }
            $existingUser->update($updateData);
            
            // Note: For existing users, we keep their existing role
            $user = $existingUser;
        } else {
            // Create new user
            $user = User::create([
                'name' => $googleUser['name'],
                'email' => $googleUser['email'],
                'google_id' => $googleUser['id'],
                'oauth_provider' => 'google',
                'role' => $validated['role'],
                'business_name' => $validated['business_name'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'is_verified' => $validated['role'] === 'seller', // Sellers auto-verified
                'email_verified_at' => now(), // Google OAuth emails are verified
                'password' => Hash::make($validated['password']),
            ]);
        }

        event(new Registered($user));

        // Notify admins
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            if ($user->role === 'buyer') {
                Notification::notify(
                    $admin,
                    'new_buyer_registration',
                    'New Buyer Registration (Google)',
                    "{$user->name} ({$user->email}) has registered as a buyer via Google and is pending verification.",
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
                    'New Seller Registered (Google)',
                    "{$user->name} ({$user->email}) has registered as a seller via Google.",
                    [
                        'user_id' => $user->id,
                        'user_name' => $user->name,
                        'user_email' => $user->email,
                        'business_name' => $user->business_name,
                    ]
                );
            }
        }

        // Notify user
        if ($user->role === 'seller') {
            Notification::notify(
                $user,
                'seller_registration_success',
                'Welcome to E-Benta! 🎉',
                'Your seller account has been created via Google. Start creating listings to reach buyers.',
                ['user_id' => $user->id]
            );
        }

        // Logout any previous/old session
        Auth::logout();
        session()->regenerate();

        // Login user immediately
        Auth::login($user);
        request()->session()->put('auth_via_google', true);

        // Clear session
        session()->forget('google_user');
        session()->forget('google_user_hash');
        session()->forget('pending_verification_user_id');

        // Log the registration
        AuditLogger::log(
            action: 'register',
            description: "User auto-registered and logged in via Google OAuth (awaiting admin verification)",
            modelType: 'User',
            modelId: $user->id,
            newValues: ['oauth_provider' => 'google', 'role' => $user->role]
        );

        // Redirect to appropriate dashboard based on role
        if ($user->role === 'seller') {
            $redirectRoute = 'seller.dashboard';
            $message = 'Welcome to E-Benta! Your seller account has been created. You can now start creating listings.';
        } elseif ($user->role === 'buyer') {
            $redirectRoute = 'buyer.dashboard';
            $message = 'Welcome to E-Benta! Your buyer account has been created. Awaiting admin verification before you can make offers.';
        } else {
            $redirectRoute = '/';
            $message = 'Welcome to E-Benta!';
        }

        return redirect()->route($redirectRoute)->with('success', $message);
    }
}

