# E-Benta Quick Start Guide

## 🚀 Getting Started

### Prerequisites
- PHP 8.2+
- Composer
- MySQL
- Node.js & npm

### Installation Steps

```bash
# 1. Navigate to project directory
cd c:\xampp\htdocs\E-Benta

# 2. Install PHP dependencies
composer install

# 3. Install JavaScript dependencies
npm install

# 4. Create environment file
copy .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Configure database in .env
# Update these values:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=ebenta
# DB_USERNAME=root
# DB_PASSWORD=

# 7. Create database
# Create new MySQL database named 'ebenta' via phpMyAdmin or command line:
# mysql -u root -e "CREATE DATABASE ebenta;"

# 8. Run migrations
php artisan migrate

# 9. (Optional) Create admin user via Tinker
php artisan tinker
>>> use App\Models\User;
>>> use Illuminate\Support\Facades\Hash;
>>> User::create(['name' => 'Admin User', 'email' => 'admin@ebenta.local', 'password' => Hash::make('password'), 'role' => 'admin', 'is_verified' => true])
>>> exit
```

### Running the Application

**Option 1: Using Artisan Serve (Simple)**
```bash
# Terminal 1 - Start Laravel server
php artisan serve

# Terminal 2 - Start Vite dev server
npm run dev

# Access at http://localhost:8000
```

**Option 2: Using XAMPP (Production-like)**
- Place project in `xampp\htdocs\E-Benta`
- Configure virtual host in Apache
- Access via `http://ebenta.local` (after hosts file setup)

## 📋 Test Accounts

After migration, create test accounts:

### Test Seller
```
Email: seller@ebenta.local
Password: password
URL: /register → Select "Seller"
```

### Test Buyer
```
Email: buyer@ebenta.local
Password: password
URL: /register → Select "Buyer"
Note: Account will be pending admin verification
```

### Admin
```
Email: admin@ebenta.local
Password: password
Created via Tinker (see above)
```

## 🔄 User Flow Testing

### 1. Test Seller Listing
```
1. Login as seller@ebenta.local
2. Go to "My Listings" → "Create New Listing"
3. Fill form:
   - Category: Laptop
   - Condition: Working
   - Description: Dell XPS 13, great condition
   - Action: Sell
4. Submit
5. Item should be valued at ~$100 and set as "available"
```

### 2. Test Buyer Registration & Verification
```
1. Register as buyer@ebenta.local
2. Login as admin@ebenta.local
3. Go to Admin → Pending Verifications
4. Review buyer account
5. Click "Verify"
6. Buyer can now submit offers
```

### 3. Test Offer Workflow
```
1. Login as verified buyer
2. Go to Dashboard → Browse Available Listings
3. Click "Make Offer" on seller's listing
4. Submit offer with:
   - Amount: $75
   - Method: Repair (for resale)
   - Pickup Date: Tomorrow
   - Location: Your address
5. Login as seller
6. View pending offers
7. Accept the offer
8. Item status changes to "matched"
```

### 4. Test Processing & Impact
```
1. Login as buyer (after offer accepted)
2. Click "Confirm Pickup" when ready
3. Item status changes to "in_transit"
4. Submit processing report:
   - Processing Method: Repair
   - Materials (optional): Copper 0.5kg, Plastic 0.1kg
5. System creates ImpactLog with:
   - CO2 Saved: 30 kg (2kg device × 15)
   - Landfill Diverted: 2 kg
   - Materials Recovered: 0.6 kg
6. Digital Certificate generated
7. Seller receives proof of responsible disposal
```

### 5. Test Admin Dashboard
```
1. Login as admin@ebenta.local
2. View statistics:
   - Total users, listings, offers, transactions
   - CO2 Saved, E-Waste Diverted
   - Active sellers & buyers
3. Generate Reports:
   - Monthly, Quarterly, Yearly options
4. View recent transactions
```

## 🐛 Troubleshooting

### Database Connection Error
```
→ Check .env file DB credentials
→ Ensure MySQL service is running
→ Create database: mysql -u root -e "CREATE DATABASE ebenta;"
```

### Port Already in Use
```
→ Run on different port: php artisan serve --port=8001
→ Access: http://localhost:8001
```

### CSS/JS Not Loading
```
→ Run: npm run build
→ Clear cache: php artisan cache:clear
```

### File Upload Issues
```
→ Check storage permissions: chmod -R 755 storage
→ Create link: php artisan storage:link
```

### Migration Errors
```
→ Check migrations exist in database/migrations/
→ Run: php artisan migrate:reset then php artisan migrate
```

## 📊 Database Structure

**4 Main Tables:**
- `users` - 8 new fields (role, is_verified, business fields, impact metrics)
- `listings` - 18 fields (item details, status, environmental data)
- `offers` - 9 fields (bidding, processing method, scheduling)
- `impact_logs` - 18 fields (environmental impact tracking, certificates)

**Total Records in Fresh Install:** 0 (ready for data entry)

## 🎯 Key Routes to Test

| Route | Purpose | Access |
|-------|---------|--------|
| `/` | Home page | Public |
| `/listings` | Browse all items | Public |
| `/register` | Create account | Guest |
| `/login` | Sign in | Guest |
| `/seller/dashboard` | Seller management | Sellers |
| `/buyer/dashboard` | Buyer dashboard | Verified Buyers |
| `/admin/dashboard` | Admin panel | Admin |
| `/admin/verifications/pending` | Approve buyers | Admin |

## 💡 Commands Reference

```bash
# Development
php artisan serve                    # Start server
npm run dev                          # Vite dev server

# Database
php artisan migrate                  # Run migrations
php artisan migrate:reset            # Reset database
php artisan migrate:fresh            # Fresh migration
php artisan tinker                   # Interactive shell

# Cache & Cleanup
php artisan cache:clear              # Clear cache
php artisan config:clear             # Clear config cache
php artisan view:clear               # Clear compiled views

# Utilities
php artisan storage:link             # Link storage directory
php artisan make:migration name      # Create migration
php artisan make:model name          # Create model
php artisan make:controller name     # Create controller
```

## 📝 Directory Permissions

For production, set proper permissions:
```bash
chmod -R 755 app/
chmod -R 755 bootstrap/cache/
chmod -R 755 storage/
chmod -R 755 public/
```

## 🚀 Deployment Checklist

- [ ] Create MySQL database on production server
- [ ] Set `.env` with production database credentials
- [ ] Set `APP_ENV=production` and `APP_DEBUG=false`
- [ ] Generate unique `APP_KEY`
- [ ] Run `composer install --no-dev`
- [ ] Run migrations: `php artisan migrate --force`
- [ ] Set proper file permissions (755 for dirs, 644 for files)
- [ ] Configure web server to serve from `public/` directory
- [ ] Set up SSL certificates
- [ ] Configure email service for notifications
- [ ] Set up backup strategy
- [ ] Monitor error logs and performance

## 📞 Support Features

For implementation of notifications:
- Email notifications for offer status
- In-app notification badges
- SMS alerts (optional)
- Webhook integration for third-party systems

## 🎓 Learning Resources

- [Laravel Documentation](https://laravel.com/docs/12.x)
- [Blade Templating](https://laravel.com/docs/12.x/blade)
- [Eloquent ORM](https://laravel.com/docs/12.x/eloquent)
- [Database Migrations](https://laravel.com/docs/12.x/migrations)

---

**Happy E-Waste Managing! ♻️**
