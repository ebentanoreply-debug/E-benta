# E-Benta Quick Reference Guide

## API Routes Summary

### 🔐 Authentication Routes (Public)
| Method | Route | Handler | Description |
|--------|-------|---------|-------------|
| GET | `/register` | AuthController@showRegistrationForm | Registration form |
| POST | `/register` | AuthController@register | Create account |
| GET | `/login` | AuthController@showLoginForm | Login form |
| POST | `/login` | AuthController@login | Authenticate user |
| GET | `/forgot-password` | AuthController@showForgotPasswordForm | Password recovery form |
| POST | `/forgot-password` | AuthController@sendForgotPasswordEmail | Send reset email |
| GET | `/reset-password/{token}` | AuthController@showResetPasswordForm | Reset password form |
| POST | `/reset-password` | AuthController@resetPassword | Update password |
| GET | `/auth/google` | GoogleAuthController@redirect | Redirect to Google |
| GET | `/auth/google/callback` | GoogleAuthController@callback | Google OAuth callback |
| GET | `/auth/google/select-role` | GoogleAuthController@showSelectRole | Select role (new OAuth user) |
| POST | `/auth/google/complete-registration` | GoogleAuthController@completeRegistration | Complete OAuth registration |

### 👤 User Profile Routes (Authenticated)
| Method | Route | Handler | Description |
|--------|-------|---------|-------------|
| GET | `/profile` | AuthController@showProfile | View profile |
| PUT | `/profile` | AuthController@updateProfile | Update profile |
| GET | `/change-password` | AuthController@showChangePasswordForm | Change password form |
| POST | `/change-password` | AuthController@changePassword | Update password |
| GET | `/change-email` | AuthController@showEmailChangeRequestForm | Email change form |
| POST | `/change-email` | AuthController@sendEmailChangeRequest | Request email change |
| GET | `/verify-email-change/{token}` | AuthController@showVerifyEmailChangeForm | Verify new email |
| POST | `/verify-email-change` | AuthController@verifyEmailChange | Confirm email change |

### 📦 Listing Routes
| Method | Route | Handler | Description |
|--------|-------|---------|-------------|
| GET | `/listings` | ListingController@index | Browse all listings |
| GET | `/listings/{id}` | ListingController@show | View listing details |
| GET | `/listings/create` | ListingController@create | Create listing form |
| POST | `/listings` | ListingController@store | Save new listing |
| GET | `/listings/{id}/edit` | ListingController@edit | Edit listing form |
| PUT | `/listings/{id}` | ListingController@update | Save listing changes |
| POST | `/listings/{id}/withdraw` | ListingController@withdraw | Remove listing |

### 💰 Offer Routes
| Method | Route | Handler | Description |
|--------|-------|---------|-------------|
| GET | `/offers/create/{listing_id}` | OfferController@create | Make offer form |
| POST | `/offers` | OfferController@store | Submit offer |
| GET | `/offers/{id}` | OfferController@show | View offer details |
| PUT | `/offers/{id}/accept` | OfferController@accept | Accept offer |
| PUT | `/offers/{id}/reject` | OfferController@reject | Reject offer |

### 🏪 Seller Routes (role: seller)
| Method | Route | Handler | Description |
|--------|-------|---------|-------------|
| GET | `/seller/dashboard` | ListingController@sellerDashboard | Seller dashboard |
| GET | `/seller/my-listings` | ListingController@sellerListings | View own listings |
| GET | `/seller/sales-analytics` | OfferController@sellerSalesAnalytics | Sales analytics |
| GET | `/seller/transaction-history` | OfferController@sellerTransactionHistory | Transaction history |
| GET | `/listings/{id}/offers` | ListingController@getOffers | View offers on listing |

### 🛍️ Buyer Routes (role: buyer)
| Method | Route | Handler | Description |
|--------|-------|---------|-------------|
| GET | `/buyer/dashboard` | OfferController@buyerDashboard | Buyer dashboard |
| GET | `/buyer/transaction-history` | OfferController@buyerTransactionHistory | Purchase history |
| GET | `/buyer/saved-items` | SavedItemController@index | View saved listings |
| POST | `/buyer/saved-items/{listing}` | SavedItemController@store | Save listing |
| DELETE | `/buyer/saved-items/{listing}` | SavedItemController@destroy | Unsave listing |

### ⚙️ Admin Routes (role: admin)
| Method | Route | Handler | Description |
|--------|-------|---------|-------------|
| GET | `/admin/dashboard` | AdminController@dashboard | Admin dashboard |
| GET | `/admin/users` | AdminController@users | Manage users |
| GET | `/admin/users/{id}` | AdminController@showUser | User details |
| PUT | `/admin/users/{id}/verify` | AdminController@verify | Verify user |
| DELETE | `/admin/users/{id}` | AdminController@suspend | Suspend user |
| GET | `/admin/listings` | AdminController@listings | View all listings |
| GET | `/admin/offers` | AdminController@offers | View all offers |
| GET | `/admin/audit-logs` | AuditLogController@index | View audit logs |
| GET | `/admin/reports` | ReportController@index | Generate reports |

---

## Core Models & Relationships

### User Model
```php
class User extends Authenticatable {
    // Properties
    $fillable = [
        'name', 'email', 'password', 'role', 'is_verified',
        'business_name', 'business_description', 'phone',
        'google_id', 'oauth_provider', 'oauth_token',
        'total_impact_score', 'items_processed', 
        'total_weight_diverted', 'total_co2_saved'
    ];
    
    // Relationships
    listings()              // HasMany - User's listings
    offers()               // HasMany - Offers made by buyer
    reviews()              // HasMany - Reviews from others
    impactLogs()           // HasMany - Environmental impact
    notifications()        // HasMany - User notifications
    addresses()            // HasMany - Delivery addresses
    savedItems()           // HasMany - Wishlist items
    passwordResetTokens()  // HasMany - Reset tokens
    emailChangeTokens()    // HasMany - Email change requests
}
```

### Listing Model
```php
class Listing extends Model {
    // Properties
    $fillable = [
        'user_id', 'device_type_id', 'device_brand_id', 'device_model_id',
        'condition', 'description', 'estimated_weight', 'intended_action',
        'suggested_price', 'status', 'matched_buyer_id', 'carbon_footprint'
    ];
    
    // Relationships
    seller()               // BelongsTo User
    deviceType()           // BelongsTo DeviceType
    deviceBrand()          // BelongsTo DeviceBrand
    deviceModel()          // BelongsTo DeviceModel
    photos()               // HasMany ListingPhoto (normalized)
    offers()               // HasMany Offer
    matchedBuyer()         // BelongsTo User
    reviews()              // HasMany Review
    impactLogs()           // HasMany ImpactLog
}
```

### Offer Model
```php
class Offer extends Model {
    // Properties
    $fillable = [
        'listing_id', 'buyer_id', 'bid_amount', 'proposed_method',
        'notes', 'proposed_pickup_date', 'pickup_location', 'status'
    ];
    
    // Relationships
    listing()              // BelongsTo Listing
    buyer()                // BelongsTo User
    reviews()              // HasMany Review
}
```

### 3NF Normalized Models
```php
// ListingPhoto (replaced listings.photos JSON)
class ListingPhoto extends Model {
    listing()              // BelongsTo Listing
}

// ReviewAttribute (replaced reviews.attributes JSON)
class ReviewAttribute extends Model {
    review()               // BelongsTo Review
}

// PasswordResetToken (replaced users.password_reset_token)
class PasswordResetToken extends Model {
    user()                 // BelongsTo User
}

// EmailChangeToken (replaced users.email_change_token*)
class EmailChangeToken extends Model {
    user()                 // BelongsTo User
}

// NotificationData (replaced notifications.data JSON)
class NotificationData extends Model {
    notification()         // BelongsTo Notification
}

// AuditLogChange (replaced audit_logs.old_values/new_values JSON)
class AuditLogChange extends Model {
    auditLog()             // BelongsTo AuditLog
}

// DeviceCategoryMapping (optimized device type lookup)
class DeviceCategoryMapping extends Model {
    // Links device_type/brand/model to category name
}
```

---

## Database Constraints & Keys

### Primary Keys (All Models)
```
All tables have: id INT AUTO_INCREMENT PRIMARY KEY
```

### Foreign Key Constraints
```
listings.user_id → users.id ON DELETE CASCADE
listings.device_type_id → device_types.id
listings.device_brand_id → device_brands.id
listings.device_model_id → device_models.id
listings.matched_buyer_id → users.id ON DELETE SET NULL

offers.listing_id → listings.id ON DELETE CASCADE
offers.buyer_id → users.id ON DELETE CASCADE

listing_photos.listing_id → listings.id ON DELETE CASCADE
password_reset_tokens.user_id → users.id ON DELETE CASCADE
email_change_tokens.user_id → users.id ON DELETE CASCADE
review_attributes.review_id → reviews.id ON DELETE CASCADE
notification_data.notification_id → notifications.id ON DELETE CASCADE
audit_log_changes.audit_log_id → audit_logs.id ON DELETE CASCADE
```

### Unique Constraints
```
users.email - UNIQUE
users.google_id - UNIQUE (nullable for local users)
device_types.name - UNIQUE
device_brands.name - UNIQUE
password_reset_tokens.token - UNIQUE
email_change_tokens.token - UNIQUE (abbr: ect_token_unique)
device_category_mappings - COMPOSITE (dcm_unique_device)
review_attributes - COMPOSITE (ra_review_attr_unique)
```

---

## Authentication Flows at a Glance

### Local Registration & Login
```
1. Register: /register → create user with bcrypt(password)
2. Admin verification required (is_verified = false)
3. Login: /login → verify password against bcrypt hash
4. Session created if is_verified = true
```

### Google OAuth Registration
```
1. Click "Login with Google"
2. Consent screen → authorization code
3. Exchange for access token
4. Auto-create user if new (google_id + oauth_token stored)
5. Redirect to /auth/google/select-role
6. User selects role → session created
7. account auto-verified via Google
```

### Password Reset Flow
```
1. /forgot-password → enter email
2. Generate token (64 chars) → store in password_reset_tokens
3. Email sent with /reset-password/{token} link
4. User clicks → verify token not expired (< 60 min)
5. Enter new password → hash with bcrypt → save
6. Token deleted → user can login
```

### Email Change Flow (OAuth Users)
```
1. /change-email → enter new email
2. Generate token → store in email_change_tokens
3. Verification email sent to new address
4. User clicks /verify-email-change/{token}
5. Verify token & expiry (< 24 hr)
6. Update users.email → clear oauth_token if applicable
7. Confirmation emails to both addresses
```

---

## Listing Lifecycle

```
CREATED (in-memory) 
    ↓ POST /listings
ACTIVE (accepting offers)
    ↓ seller accepts offer
MATCHED (reserved for buyer)
    ↓ transaction completes
COMPLETED (sale finished)

OR:

ACTIVE → WITHDRAWN (seller cancels)
MATCHED → CANCELLED (deal falls through)
ANY → DELETED (admin removes)
```

---

## Offer Lifecycle

```
PENDING (waiting for seller response)
    ↓
├─ ACCEPTED (seller approves)
│  ↓
│  COMPLETED (after delivery)
│
└─ REJECTED (seller declines)
```

---

## Environmental Impact Tracking

### When Transaction Completes
```
User Impact Score Updated:
- total_impact_score += listing.carbon_footprint
- items_processed += 1
- total_weight_diverted += listing.estimated_weight
- total_co2_saved += listing.carbon_footprint

ImpactLog Created:
- user_id: seller
- item_id: listing.id
- impact_type: 'device_sold'
- carbon_saved: listing.carbon_footprint (kg)
- weight_diverted: listing.estimated_weight (kg)
```

### Available Metrics
```
Per User:
- total_impact_score (decimal) - Cumulative environmental score
- items_processed (int) - Number of items sold/bought
- total_weight_diverted (decimal) - kg diverted from landfill
- total_co2_saved (decimal) - kg CO2 equivalent saved

Per Listing:
- estimated_weight (decimal) - Item weight in kg
- carbon_footprint (decimal) - CO2 saved by this transaction
- calculated from: device_type + estimated_weight
```

---

## Admin Dashboard Metrics

```
Users Section:
- Total Users: COUNT(users)
- Verified: COUNT(users WHERE is_verified = true)
- Unverified: COUNT(users WHERE is_verified = false)
- Unverified Queue: Users pending admin approval

Listings Section:
- Total Listings: COUNT(listings)
- Active: COUNT(listings WHERE status = 'active')
- Matched: COUNT(listings WHERE status = 'matched')
- Completed: COUNT(listings WHERE status = 'completed')

Offers Section:
- Total Offers: COUNT(offers)
- Pending: COUNT(offers WHERE status = 'pending')
- Accepted: COUNT(offers WHERE status = 'accepted')
- Completed: COUNT(offers WHERE status = 'completed')

Environmental Impact:
- Total CO2 Saved: SUM(users.total_co2_saved)
- Total Weight Diverted: SUM(users.total_weight_diverted)
- Items Processed: SUM(users.items_processed)

Recent Activity:
- Last 10 audit_log entries
- Event types: listing_created, offer_created, offer_accepted, etc.
```

---

## Error Codes & Messages

### Authentication Errors
| Error | Cause | Solution |
|-------|-------|----------|
| "Invalid credentials" | Wrong email/password | Verify email & password |
| "Account not verified" | is_verified = false | Wait for admin approval |
| "Email already exists" | Duplicate email | Use different email |
| "Reset token expired" | Token > 60 minutes old | Request new password reset |
| "Email change token invalid" | Token expired or wrong | Request new email change |

### Listing Errors
| Error | Cause | Solution |
|-------|-------|----------|
| "Listing not found" | Invalid listing ID | Check URL |
| "Cannot bid on own listing" | Seller = buyer | Use different account |
| "Listing not active" | status != 'active' | Find active listings |
| "Invalid device type" | device_type_id not found | Select valid device |

### Offer Errors
| Error | Cause | Solution |
|-------|-------|----------|
| "Insufficient permissions" | Buyer attempting seller action | Use buyer dashboard |
| "Offer already responded" | Already accepted/rejected | Cannot change decision |
| "Listing already matched" | Another offer accepted | Make new offer |

---

## Testing Credentials

```
Admin Account (auto-verified):
  Email: admin@ebenta.com
  Password: Admin@123
  Role: admin
  Verified: Yes

Test Seller (requires local registration):
  Email: seller@test.com
  Password: TestPass123
  Role: seller
  Verified: Awaiting admin approval

Test Buyer (requires local registration):
  Email: buyer@test.com
  Password: TestPass123
  Role: buyer
  Verified: Awaiting admin approval

Google OAuth:
  Use any Google account
  Auto-creates user
  Auto-verified
  Select role on first login
```

---

## 3NF Database Tables (30+)

### Core Marketplace
- users, listings, offers, reviews, addresses
- device_types, device_brands, device_models
- listing_photos, review_attributes

### Security & Tokens
- password_reset_tokens, email_change_tokens
- email_verification_tokens (legacy)

### System Features
- notifications, notification_data
- impact_logs, saved_items
- audit_logs, audit_log_changes
- device_category_mappings

### Meta
- cache table, jobs table, failed_jobs

---

## Performance Notes

### Eager Loading (Avoid N+1)
```php
// GOOD: Load relationships with listings
Listing::with(['seller', 'photos', 'offers.buyer'])->paginate(15)

// BAD: N+1 query problem
Listing::paginate(15)  // Then accessing $listing->seller in loop
```

### Indexing
```
Indexed columns:
- users.email (unique)
- listings.user_id, listings.status
- offers.listing_id, offers.buyer_id, offers.status
- listing_photos.listing_id
- audit_logs.user_id, audit_logs.event_type
```

### Pagination
```
Default: 15 items per page
Listings browse: 15 per page
Transaction history: 20 per page
Admin tables: 25 per page
```

---

## Useful Artisan Commands

```bash
# Create new user (via tinker)
php artisan tinker
> User::create(['name'=>'X','email'=>'x@y','password'=>bcrypt('pass'),'role'=>'buyer','is_verified'=>1])

# Run migrations
php artisan migrate
php artisan migrate:rollback
php artisan migrate:reset
php artisan migrate:refresh

# Clear cache
php artisan cache:clear
php artisan view:clear

# Run tests
php artisan test

# Start development server
php artisan serve

# Generate app key
php artisan key:generate
```

---

**Last Updated:** April 19, 2026  
**System Version:** Production (3NF Normalized)  
**Admin Account:** admin@ebenta.com / Admin@123
