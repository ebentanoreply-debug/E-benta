<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your E-Benta Password Reset Code</title>
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
    <style>
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        @media screen and (max-width: 600px) {
            .email-container { width: 100% !important; padding: 10px !important; }
            .content-cell { padding: 24px 18px !important; }
            .otp-code { font-size: 32px !important; letter-spacing: 6px !important; }
            .header-cell { padding: 28px 18px !important; }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; -webkit-font-smoothing: antialiased; color: #0f172a;">

    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f1f5f9; padding: 30px 15px;">
        <tr>
            <td align="center">
                <!-- Main Container -->
                <table role="presentation" class="email-container" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 560px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06); border: 1px solid #e2e8f0;">
                    
                    <!-- Header with Gradient & Branding -->
                    <tr>
                        <td class="header-cell" style="background: linear-gradient(135deg, #059669 0%, #0d9488 50%, #0284c7 100%); padding: 36px 30px; text-align: center;">
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center">
                                        <!-- Lock Badge Icon -->
                                        <div style="display: inline-block; width: 56px; height: 56px; line-height: 56px; background-color: rgba(255, 255, 255, 0.2); border-radius: 50%; text-align: center; margin-bottom: 12px; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3);">
                                            <span style="font-size: 26px; vertical-align: middle;">🔐</span>
                                        </div>
                                        <h1 style="margin: 0; color: #ffffff; font-size: 24px; font-weight: 800; letter-spacing: -0.5px;">E-Benta</h1>
                                        <p style="margin: 6px 0 0 0; color: #e6fffa; font-size: 14px; font-weight: 500; letter-spacing: 0.3px;">Account Security & Verification</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td class="content-cell" style="padding: 36px 32px 28px 32px; background-color: #ffffff;">
                            <p style="margin: 0 0 16px 0; font-size: 16px; line-height: 1.6; color: #334155;">
                                Hello <strong style="color: #0f172a;">{{ $user->name }}</strong>,
                            </p>
                            <p style="margin: 0 0 24px 0; font-size: 15px; line-height: 1.6; color: #475569;">
                                We received a request to reset your password. Use the 6-digit verification code below to securely reset your password:
                            </p>

                            <!-- OTP Box -->
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 20px 0 28px 0;">
                                <tr>
                                    <td align="center" style="background: #f8fafc; border: 2px dashed #0d9488; border-radius: 12px; padding: 24px 16px;">
                                        <span style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; color: #0d9488; margin-bottom: 10px;">Verification Code</span>
                                        <div class="otp-code" style="font-size: 38px; font-weight: 800; letter-spacing: 8px; color: #0f766e; font-family: 'Courier New', Courier, monospace; margin-left: 8px;">
                                            {{ $code }}
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <!-- Action Button -->
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 0 0 26px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ route('password.reset', ['email' => $user->email, 'code' => $code]) }}" target="_blank" style="display: inline-block; background: linear-gradient(135deg, #0d9488 0%, #059669 100%); color: #ffffff; font-size: 15px; font-weight: 600; text-decoration: none; padding: 14px 32px; border-radius: 8px; box-shadow: 0 4px 12px rgba(13, 148, 136, 0.25);">
                                            Reset Password Now &rarr;
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Expiry Banner -->
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #fffbeb; border-radius: 8px; border-left: 4px solid #f59e0b; margin-bottom: 24px;">
                                <tr>
                                    <td style="padding: 12px 16px;">
                                        <p style="margin: 0; font-size: 13px; line-height: 1.5; color: #92400e;">
                                            ⏱️ <strong>Expires in 15 minutes.</strong> This code is single-use and will automatically expire soon.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Security Tip -->
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0; margin-bottom: 8px;">
                                <tr>
                                    <td style="padding: 14px 16px;">
                                        <p style="margin: 0 0 6px 0; font-size: 13px; font-weight: 600; color: #1e293b;">
                                            🛡️ Security Warning
                                        </p>
                                        <p style="margin: 0; font-size: 12px; line-height: 1.5; color: #64748b;">
                                            Never share this verification code with anyone. E-Benta support will never ask for your password or OTP code. If you did not make this request, you can safely ignore this email.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; padding: 22px 30px; text-align: center; border-top: 1px solid #e2e8f0;">
                            <p style="margin: 0 0 6px 0; font-size: 12px; color: #64748b; font-weight: 500;">
                                E-Benta Online Marketplace & Electronics Platform
                            </p>
                            <p style="margin: 0; font-size: 11px; color: #94a3b8;">
                                &copy; {{ date('Y') }} E-Benta. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
                <!-- End Main Container -->
            </td>
        </tr>
    </table>

</body>
</html>

