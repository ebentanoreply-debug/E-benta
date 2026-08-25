<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your E-Benta Password Reset Code</title>
</head>
<body style="margin: 0; padding: 2rem 1rem; background-color: #f0fdf4; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #1e293b;">
    <div style="max-width: 580px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05); overflow: hidden; border: 1px solid #e2e8f0;">
        
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%); padding: 2.5rem 2rem; text-align: center; color: #ffffff;">
            <h1 style="margin: 0 0 0.5rem 0; font-size: 1.75rem; font-weight: 800; letter-spacing: -0.02em;">E-Benta</h1>
            <p style="margin: 0; font-size: 1rem; opacity: 0.95;">Password Reset Request</p>
        </div>

        <!-- Body -->
        <div style="padding: 2.5rem 2rem;">
            <p style="margin: 0 0 1rem 0; font-size: 1rem; line-height: 1.5; color: #334155;">
                Hello <strong>{{ $user->name }}</strong>,
            </p>
            <p style="margin: 0 0 1.5rem 0; font-size: 0.95rem; line-height: 1.6; color: #475569;">
                We received a request to reset the password for your E-Benta account. Enter the verification code below on the password reset page to complete your request:
            </p>

            <!-- 6-Digit Code Box -->
            <div style="background: linear-gradient(135deg, #f0fdf4 0%, #ccfbf1 100%); border: 2px dashed #0d9488; border-radius: 12px; padding: 1.75rem 1rem; text-align: center; margin: 1.75rem 0;">
                <p style="margin: 0 0 0.5rem 0; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #0f766e;">
                    Your Password Reset Code
                </p>
                <div style="font-size: 2.75rem; font-weight: 800; letter-spacing: 0.25em; color: #0f766e; font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, Courier, monospace; margin-left: 0.25em;">
                    {{ $code }}
                </div>
            </div>

            <!-- Expiration Notice -->
            <div style="background-color: #fffbeb; border-left: 4px solid #f59e0b; padding: 1rem; border-radius: 8px; margin-bottom: 1.75rem;">
                <p style="margin: 0; font-size: 0.875rem; color: #92400e; line-height: 1.5;">
                    ⏳ <strong>This code will expire in 15 minutes.</strong> If the code expires, you can request a new one from the login page.
                </p>
            </div>

            <!-- Security Note -->
            <p style="margin: 0 0 0.5rem 0; font-size: 0.875rem; color: #64748b; line-height: 1.5;">
                🔒 <strong>Security Tip:</strong> Never share this code with anyone. E-Benta will never ask you for your reset code or password.
            </p>
            <p style="margin: 0; font-size: 0.85rem; color: #94a3b8; line-height: 1.5;">
                If you did not request a password reset, you can safely ignore this email. Your password will remain unchanged.
            </p>
        </div>

        <!-- Footer -->
        <div style="background-color: #f8fafc; padding: 1.5rem 2rem; border-top: 1px solid #e2e8f0; text-align: center;">
            <p style="margin: 0; font-size: 0.8rem; color: #94a3b8;">
                &copy; {{ date('Y') }} E-Benta Platform. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
