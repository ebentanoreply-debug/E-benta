<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Your E-Benta Password</title>
</head>
<body style="margin:0; padding:2rem; background:#f0fdf4; color:#1e293b; font-family:Arial,sans-serif;">
    <div style="max-width:600px; margin:0 auto; padding:2rem; background:#ffffff; border-radius:12px;">
        <h1 style="margin-top:0; color:#0d9488;">Reset your password</h1>
        <p>Hello {{ $user->name }},</p>
        <p>We received a request to reset your E-Benta password. Use the button below to choose a new password.</p>
        <p style="margin:2rem 0;">
            <a href="{{ $resetLink }}" style="display:inline-block; padding:0.85rem 1.25rem; background:#0d9488; color:#ffffff; text-decoration:none; border-radius:6px; font-weight:700;">Reset Password</a>
        </p>
        <p style="color:#64748b; font-size:0.9rem;">This link expires in one hour. If you did not request this, you can safely ignore this email.</p>
    </div>
</body>
</html>
