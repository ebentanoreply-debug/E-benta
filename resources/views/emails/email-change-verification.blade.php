<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirm Your E-Benta Email Change</title>
</head>
<body style="margin:0; padding:2rem; background:#f0fdf4; color:#1e293b; font-family:Arial,sans-serif;">
    <div style="max-width:600px; margin:0 auto; padding:2rem; background:#ffffff; border-radius:12px;">
        <h1 style="margin-top:0; color:#0d9488;">Confirm your email change</h1>
        <p>Hello {{ $user->name }},</p>
        <p>We received a request to change your E-Benta email address to <strong>{{ $newEmail }}</strong>.</p>
        <p style="margin:2rem 0;">
            <a href="{{ $verificationLink }}" style="display:inline-block; padding:0.85rem 1.25rem; background:#0d9488; color:#ffffff; text-decoration:none; border-radius:6px; font-weight:700;">Confirm Email Change</a>
        </p>
        <p style="color:#64748b; font-size:0.9rem;">This link expires in one hour. If you did not request this change, ignore this email and your current email will remain active.</p>
    </div>
</body>
</html>
