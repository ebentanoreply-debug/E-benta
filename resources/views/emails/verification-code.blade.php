@extends('layouts.app')

@section('content')
<div style="background-color: #f0fdf4; padding: 2rem; border-radius: 1rem; max-width: 600px; margin: 2rem auto;">
    <div style="background-color: white; padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 2rem;">
            <h1 style="color: #0d9488; font-size: 1.8rem; margin: 0 0 0.5rem 0;">Verify Your Email</h1>
            <p style="color: #64748b; margin: 0;">Welcome to E-Benta! Please verify your email address.</p>
        </div>

        <!-- Message -->
        <div style="background-color: #f8fafc; padding: 1.5rem; border-radius: 0.8rem; margin-bottom: 2rem; border-left: 4px solid #0d9488;">
            <p style="color: #1e293b; margin: 0 0 1rem 0; font-size: 0.95rem;">
                Hi <strong>{{ $user->name }}</strong>,
            </p>
            <p style="color: #1e293b; margin: 0; font-size: 0.95rem;">
                Your verification code is:
            </p>
        </div>

        <!-- Code Box -->
        <div style="background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%); padding: 2rem; border-radius: 0.8rem; text-align: center; margin-bottom: 2rem;">
            <p style="color: white; margin: 0 0 0.5rem 0; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em;">Your verification code</p>
            <div style="color: white; font-size: 2.5rem; font-weight: 800; letter-spacing: 0.1em; font-family: 'Courier New', monospace;">
                {{ $code }}
            </div>
        </div>

        <!-- Info -->
        <div style="background-color: #fff7ed; padding: 1rem; border-radius: 0.8rem; margin-bottom: 2rem; border-left: 4px solid #f97316;">
            <p style="color: #78350f; margin: 0; font-size: 0.85rem;">
                <strong>⏰ This code expires in 10 minutes</strong><br>
                If you don't enter this code within 10 minutes, you'll need to request a new one.
            </p>
        </div>

        <!-- Instructions -->
        <div style="background-color: #f0f9ff; padding: 1rem; border-radius: 0.8rem; margin-bottom: 2rem;">
            <p style="color: #0369a1; margin: 0; font-size: 0.9rem;">
                <strong>How to verify:</strong><br>
                1. Go back to E-Benta<br>
                2. Paste or type the code above<br>
                3. Click "Verify Email"
            </p>
        </div>

        <!-- Security Note -->
        <div style="border-top: 1px solid #e2e8f0; padding-top: 1.5rem; text-align: center;">
            <p style="color: #64748b; font-size: 0.85rem; margin: 0;">
                <strong>Security tip:</strong> Never share this code with anyone. E-Benta staff will never ask for your verification code.
            </p>
        </div>

        <!-- Footer -->
        <div style="border-top: 1px solid #e2e8f0; padding-top: 1.5rem; text-align: center; margin-top: 2rem;">
            <p style="color: #94a3b8; font-size: 0.8rem; margin: 0;">
                Questions? Contact us at support@ebenta.com
            </p>
        </div>
    </div>
</div>
@endsection
