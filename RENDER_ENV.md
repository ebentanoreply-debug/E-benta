# 🚀 Render Deployment Environment Variables

Copy and paste the entire block below directly into your Render Web Service (**Environment** $\rightarrow$ **Add from .env** or Bulk Editor). Replace the placeholder values with your actual secret credentials in the Render dashboard:

```env
# Application Settings
APP_NAME=E-Benta
APP_ENV=production
APP_KEY=base64:2LmhtVEIIhA8re6+i4Dy31BsSv23+2ojmNMZY9vyhXY=
APP_DEBUG=false
APP_URL=https://e-benta.onrender.com

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

# Logging (Streams live to Render Dashboard)
LOG_CHANNEL=stderr
LOG_LEVEL=info

# Database Configuration (TiDB Cloud / MySQL with SSL)
DB_CONNECTION=mysql
DB_HOST=gateway01.ap-southeast-1.prod.aws.tidbcloud.com
DB_PORT=4000
DB_DATABASE=ebenta
DB_USERNAME=3AKeWCsrAvzDTCf.root
DB_PASSWORD=your_tidb_password_here
MYSQL_ATTR_SSL_CA=/etc/ssl/certs/ca-certificates.crt

# Drivers & Storage (Database-backed for multi-instance persistence)
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
QUEUE_CONNECTION=database
CACHE_STORE=database

# Cloudflare R2 Cloud Storage Settings
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your_cloudflare_r2_access_key_here
AWS_SECRET_ACCESS_KEY=your_cloudflare_r2_secret_access_key_here
AWS_DEFAULT_REGION=auto
AWS_BUCKET=gasgo-assets
AWS_ENDPOINT=https://fa270ac2fbe07cac12ef328e8f355c72.r2.cloudflarestorage.com
AWS_URL=https://pub-034cbfc971d6455993f7ec82c6c55771.r2.dev
AWS_USE_PATH_STYLE_ENDPOINT=true

# Brevo (Sendinblue) SMTP Email Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp-relay.brevo.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
MAIL_USERNAME=your_brevo_login_email@example.com
MAIL_PASSWORD=your_brevo_smtp_master_key
MAIL_FROM_ADDRESS=your_verified_sender_email@example.com
MAIL_FROM_NAME="E-benta"

# Google OAuth Configuration
GOOGLE_CLIENT_ID=your_google_client_id_here
GOOGLE_CLIENT_SECRET=your_google_client_secret_here
GOOGLE_CALLBACK_URL=https://e-benta.onrender.com/auth/google/callback

VITE_APP_NAME="E-benta"
```

---

## 🔑 Environment Variables Breakdown & Reference

| Environment Variable | Recommended Value | Purpose |
| :--- | :--- | :--- |
| `DB_CONNECTION` | `mysql` | MySQL PDO connection driver |
| `DB_HOST` | `gateway01.ap-southeast-1.prod.aws.tidbcloud.com` | TiDB Cloud serverless host |
| `DB_PORT` | `4000` | TiDB Cloud port |
| `DB_DATABASE` | `ebenta` | Database schema name |
| `DB_USERNAME` | `3AKeWCsrAvzDTCf.root` | TiDB Cloud database user |
| `DB_PASSWORD` | *(Set in Render Dashboard)* | TiDB Cloud database password |
| `MYSQL_ATTR_SSL_CA` | `/etc/ssl/certs/ca-certificates.crt` | System CA bundle to secure SSL connection to TiDB |
| `APP_NAME` | `E-benta` | Application title |
| `APP_ENV` | `production` | Enables production optimizations |
| `APP_KEY` | `base64:...` | Laravel application encryption key |
| `APP_DEBUG` | `false` | Disables debug mode for security |
| `APP_URL` | `https://e-benta.onrender.com` | Live Render Web Service URL |
| `LOG_CHANNEL` | `stderr` | Outputs logs directly to Render log viewer |
| `SESSION_DRIVER` | `database` | Stores user sessions across restarts |
| `QUEUE_CONNECTION` | `database` | Background job processing via database table |
| `CACHE_STORE` | `database` | Cache storage in database table |
| `FILESYSTEM_DISK` | `s3` | Uses Cloudflare R2 (S3-compatible object storage) |
| `AWS_ACCESS_KEY_ID` | *(Set in Render Dashboard)* | Cloudflare R2 Access Key |
| `AWS_SECRET_ACCESS_KEY` | *(Set in Render Dashboard)* | Cloudflare R2 Secret Key |
| `AWS_DEFAULT_REGION` | `auto` | Cloudflare R2 auto region |
| `AWS_BUCKET` | `gasgo-assets` | Cloudflare R2 bucket name |
| `AWS_ENDPOINT` | `https://fa270ac2fbe07cac12ef328e8f355c72.r2.cloudflarestorage.com` | Cloudflare R2 S3 API Endpoint |
| `AWS_URL` | `https://pub-034cbfc971d6455993f7ec82c6c55771.r2.dev` | Cloudflare R2 public assets URL |
| `AWS_USE_PATH_STYLE_ENDPOINT` | `true` | Required for Cloudflare R2 bucket path addressing |
| `MAIL_MAILER` | `resend` | Resend API mailer (works on HTTP port 443) |
| `RESEND_API_KEY` | *(Set in Render Dashboard)* | Resend API authorization token |
| `MAIL_FROM_ADDRESS` | `onboarding@resend.dev` | Verified sending email address |
| `MAIL_FROM_NAME` | `"E-benta"` | Sender display name |
| `GOOGLE_CLIENT_ID` | *(Set in Render Dashboard)* | Google OAuth Client ID |
| `GOOGLE_CLIENT_SECRET` | *(Set in Render Dashboard)* | Google OAuth Client Secret |
| `GOOGLE_CALLBACK_URL` | `https://e-benta.onrender.com/auth/google/callback` | Google OAuth Callback URL |

---

## ⚡ How Migration & Seeding Runs Once

The container's startup script runs:
```bash
php artisan app:init-db
```
- **`migrate --force`**: Always runs any pending migrations safely.
- **`db:seed --force`**: Checks if the `users` table is empty (`User::count() === 0`).
  - First run / fresh deployment: seeds devices, roles, admin, seller, and buyer accounts.
  - Subsequent runs / restarts: automatically skips seeding to avoid duplicate record errors.
