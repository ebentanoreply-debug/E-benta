# E-Benta Architecture & Data Flow Reference

## System Architecture Layers

```
┌─────────────────────────────────────────────────────────────┐
│                     PRESENTATION LAYER                       │
│        Blade Templates + Vue.js Components + Vite           │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  ┌─── Seller Views ────┐  ┌─── Buyer Views ────┐           │
│  │ - Dashboard         │  │ - Dashboard        │           │
│  │ - Create Listing    │  │ - Browse Listings  │           │
│  │ - View Offers       │  │ - Make Offers      │           │
│  │ - Sales Analytics   │  │ - Transaction Hist │           │
│  │ - Transaction Hist  │  │ - Saved Items      │           │
│  └─────────────────────┘  └────────────────────┘           │
│                                                              │
│  ┌─── Admin Views ────────┐  ┌─── Public Views ──────┐     │
│  │ - User Management      │  │ - Browse Listings     │     │
│  │ - Verification Queue   │  │ - View Details        │     │
│  │ - Audit Logs           │  │ - Login/Register      │     │
│  │ - Reports/Analytics    │  │ - Authentication      │     │
│  └────────────────────────┘  └───────────────────────┘     │
│                                                              │
├─────────────────────────────────────────────────────────────┤
│                     APPLICATION LAYER                       │
│              HTTP Controllers & Route Handlers              │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  ┌────────────────┐  ┌───────────────┐  ┌──────────────┐   │
│  │ AuthController │  │ Listing       │  │ Offer        │   │
│  │                │  │ Controller    │  │ Controller   │   │
│  │ - register     │  │ - index       │  │ - create     │   │
│  │ - login        │  │ - create      │  │ - store      │   │
│  │ - logout       │  │ - store       │  │ - show       │   │
│  │ - changePass   │  │ - edit        │  │ - accept     │   │
│  │ - changeEmail  │  │ - update      │  │ - reject     │   │
│  │                │  │ - withdraw    │  │ - analytics  │   │
│  └────────────────┘  └───────────────┘  └──────────────┘   │
│                                                              │
│  ┌────────────────┐  ┌───────────────┐  ┌──────────────┐   │
│  │ GoogleAuth     │  │ Admin         │  │ Review       │   │
│  │ Controller     │  │ Controller    │  │ Controller   │   │
│  │ - redirect     │  │ - dashboard   │  │ - store      │   │
│  │ - callback     │  │ - users       │  │ - show       │   │
│  │ - selectRole   │  │ - verify      │  │ - delete     │   │
│  └────────────────┘  └───────────────┘  └──────────────┘   │
│                                                              │
├─────────────────────────────────────────────────────────────┤
│                    BUSINESS LOGIC LAYER                     │
│            Models, Relationships & Services                 │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  ┌─────────────────────────────────────────────────────┐   │
│  │  Core Models (Eloquent ORM)                         │   │
│  │  ├── User (with role: seller/buyer/admin)          │   │
│  │  ├── Listing (with device hierarchy)               │   │
│  │  ├── Offer (with status transitions)               │   │
│  │  ├── Review (with 3NF attributes)                  │   │
│  │  ├── ImpactLog (environmental tracking)            │   │
│  │  ├── Notification (with normalized data)           │   │
│  │  ├── AuditLog (with field change tracking)         │   │
│  │  └── ... (21 more models)                          │   │
│  └─────────────────────────────────────────────────────┘   │
│                                                              │
│  ┌─────────────────────────────────────────────────────┐   │
│  │  3NF Normalized Child Models                        │   │
│  │  ├── ListingPhoto (from listings.photos JSON)      │   │
│  │  ├── ReviewAttribute (from reviews.attributes)    │   │
│  │  ├── PasswordResetToken (from users.column)       │   │
│  │  ├── EmailChangeToken (from users.columns)        │   │
│  │  ├── NotificationData (from notifications.data)   │   │
│  │  ├── AuditLogChange (from audit_logs JSON)        │   │
│  │  └── DeviceCategoryMapping (lookup table)          │   │
│  └─────────────────────────────────────────────────────┘   │
│                                                              │
│  ┌─────────────────────────────────────────────────────┐   │
│  │  Services & Utilities                              │   │
│  │  ├── AuthenticationService                         │   │
│  │  ├── OAuth (Google Socialite)                      │   │
│  │  ├── EmailService                                  │   │
│  │  ├── ImpactCalculationService                      │   │
│  │  ├── ListingService                                │   │
│  │  ├── OfferNegotiationService                       │   │
│  │  └── ValidationService                             │   │
│  └─────────────────────────────────────────────────────┘   │
│                                                              │
├─────────────────────────────────────────────────────────────┤
│                     DATA ACCESS LAYER                       │
│      Eloquent ORM & Database Query Builder                 │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  ORM Features:                                             │
│  ├── Relationships (BelongsTo, HasMany, HasManyThrough)  │
│  ├── Accessors & Mutators (data transformation)         │
│  ├── Soft Deletes (logical deletion)                   │
│  ├── Timestamps (created_at, updated_at)              │
│  ├── Eager Loading (prevent N+1 queries)              │
│  └── Query Scopes (reusable query logic)              │
│                                                              │
├─────────────────────────────────────────────────────────────┤
│                    DATABASE LAYER                           │
│          MySQL 8.0 with 30+ Normalized Tables            │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  Database: ebenta                                          │
│  Engine: InnoDB (ACID transactions)                       │
│  Charset: utf8mb4 (full Unicode support)               │
│                                                              │
│  Schema Features:                                          │
│  ├── Foreign Key Constraints (relational integrity)      │
│  ├── Unique Constraints (data uniqueness)               │
│  ├── Composite Keys (multi-column uniqueness)           │
│  ├── Cascade Deletes (data cleanup)                    │
│  ├── Indexes (query performance)                       │
│  └── Soft Deletes (retention with logical deletion)    │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

---

## User Registration Data Flow

```
START: User visits /register
  │
  ├─────────────────────────────────────────┐
  │                                         │
  ↓                                         ↓
[Local Registration]              [Google OAuth Registration]
  │                                         │
  │ 1. Form submission                     │ 1. Click "Login with Google"
  │    - name, email, password             │ 2. Redirect to Google consent
  │    - role (seller/buyer)               │ 3. User grants permissions
  │                                        │ 4. Google redirects to callback
  ↓                                        ↓
[AuthController@register]        [GoogleAuthController@callback]
  │                                        │
  ├─ Validate input                       ├─ Exchange auth code
  │                                       ├─ Get user info from Google
  │                                       │
  ↓                                        ↓
[User Model - Create]            [Google API Response]
  │                              name, email, google_id,
  ├─ Hash password              access_token, etc.
  │  bcrypt(password, cost: 12) │
  ├─ Set is_verified = false    ↓
  │  (requires admin)          [User Model - Create or Update]
  ├─ Set role = seller/buyer   ├─ Create if new user
  │                            ├─ Set google_id (unique)
  ↓                            ├─ Set oauth_provider = 'google'
[MySQL: INSERT INTO users]     ├─ Set oauth_token (JWT)
  │                            ├─ Set is_verified = true (auto)
  ├─ user.id = auto            ├─ Set password = NULL
  ├─ user.email = unique       │
  ├─ user.password = bcrypt    ↓
  ├─ user.role = 'seller'|'buyer'  [MySQL: INSERT INTO users]
  ├─ user.is_verified = false  │
  └─ user.created_at = now()   ├─ user.google_id = from Google
                               ├─ user.is_verified = true
[AuditLog Entry Created]       └─ user.oauth_token = stored
  │
  ├─ event_type = 'user_registered'
  ├─ changes = user details
  │
  ↓
[Notification Queue]
  │
  ├─ Admin notification (local user)
  │  "New unverified user: John Doe"
  │
  ├─ OR
  │
  ├─ Redirect to /auth/google/select-role (OAuth user)
  │  User picks role → confirm registration
  │
  ↓
END: User account created
```

---

## Listing Creation & Publishing Data Flow

```
START: Authenticated Seller visits /listings/create
  │
  ↓
[ListingController@create]
  │ Display form with:
  │ - Device type dropdown (from device_types table)
  │ - Device brand (filtered by type)
  │ - Device model (filtered by brand)
  │ - Condition (new/like-new/used/poor)
  │ - Description textarea
  │ - Weight slider (kg)
  │ - Intended action (repair/resale/refurbish/recycle)
  │ - Seller's asking price
  │ - Photo upload (multiple files)
  │
  ↓
[User submits form]
  │
  ↓
[ListingController@store]
  │
  ├─ Validate inputs
  │  ├─ Required fields present
  │  ├─ Device IDs exist in database
  │  ├─ Weight > 0
  │  ├─ Price > 0
  │  ├─ Photos uploaded & valid
  │  └─ User is authenticated seller
  │
  ├─ Calculate carbon_footprint
  │  │ Based on:
  │  ├─ device_type (different devices have different CO2 values)
  │  └─ estimated_weight (kg → CO2 saved calculation)
  │
  ├─ Store photos
  │  │ For each uploaded photo:
  │  ├─ Validate file (jpg/png)
  │  ├─ Resize & optimize
  │  ├─ Store in storage/app/public/listings/
  │  └─ Generate URL
  │
  ↓
[Listing Model - Create]
  │
  ├─ INSERT INTO listings:
  │  ├─ user_id = current seller ID
  │  ├─ device_type_id = selected
  │  ├─ device_brand_id = selected
  │  ├─ device_model_id = selected
  │  ├─ condition = selected
  │  ├─ description = text input
  │  ├─ estimated_weight = weight
  │  ├─ intended_action = action
  │  ├─ suggested_price = price
  │  ├─ carbon_footprint = calculated
  │  ├─ status = 'active'
  │  └─ created_at = now()
  │
  ↓ (Get listing ID back)
  │
  ├─ For each photo:
  │  │
  │  ↓
  │  [ListingPhoto Model - Create]
  │  │
  │  ├─ INSERT INTO listing_photos:
  │  │  ├─ listing_id = new listing ID
  │  │  ├─ photo_url = stored file path
  │  │  ├─ sort_order = 1, 2, 3...
  │  │  └─ created_at = now()
  │  │
  │
  ↓ (After all photos)
  │
  ├─ Create AuditLog entry
  │  │
  │  ├─ INSERT INTO audit_logs:
  │  │  ├─ user_id = seller ID
  │  │  ├─ resource_type = 'listing'
  │  │  ├─ resource_id = listing ID
  │  │  ├─ event_type = 'listing_created'
  │  │  └─ created_at = now()
  │  │
  │  ├─ INSERT INTO audit_log_changes (for each field):
  │  │  ├─ audit_log_id = audit log ID
  │  │  ├─ field_name = 'device_type_id'
  │  │  ├─ old_value = NULL
  │  │  ├─ new_value = device_type_id
  │  │
  ↓
[All Database Inserts Complete]
  │
  ├─ Seller redirected to /seller/dashboard
  ├─ Success message: "Listing created successfully!"
  │
  ├─ Listing now ACTIVE
  ├─ Buyers can find it in /listings
  ├─ Other sellers cannot edit it
  │
  ↓
END: Listing published
```

---

## Offer Creation & Negotiation Data Flow

```
START: Authenticated Buyer clicks "Make Offer"
  │
  ↓
[OfferController@create]
  │ Display form with:
  │ - Listing preview (seller, device, price)
  │ - Bid amount input
  │ - Pickup method dropdown
  │ - Proposed pickup date
  │ - Pickup location
  │ - Optional notes
  │
  ↓
[Buyer submits offer form]
  │
  ↓
[OfferController@store]
  │
  ├─ Validate:
  │  ├─ Listing exists & is active
  │  ├─ Buyer is authenticated & not seller
  │  ├─ Bid amount > 0
  │  ├─ Pickup date in future
  │  ├─ Pickup location not empty
  │  └─ No duplicate pending offer from same buyer
  │
  ↓
[Offer Model - Create]
  │
  ├─ INSERT INTO offers:
  │  ├─ listing_id = listing ID
  │  ├─ buyer_id = current user ID
  │  ├─ bid_amount = entered amount
  │  ├─ proposed_method = selected method
  │  ├─ proposed_pickup_date = date
  │  ├─ pickup_location = location
  │  ├─ notes = notes
  │  ├─ status = 'pending'
  │  └─ created_at = now()
  │
  ↓ (Get offer ID back)
  │
  ├─ Create Notification for Seller
  │  │
  │  ├─ INSERT INTO notifications:
  │  │  ├─ user_id = seller ID
  │  │  ├─ type = 'new_offer'
  │  │  ├─ resource_type = 'offer'
  │  │  ├─ resource_id = offer ID
  │  │  ├─ read = false
  │  │  └─ created_at = now()
  │  │
  │  ├─ INSERT INTO notification_data:
  │  │  ├─ notification_id = notification ID
  │  │  ├─ data_key = 'buyer_name'
  │  │  ├─ data_value = buyer.name
  │  │  │
  │  │  ├─ data_key = 'bid_amount'
  │  │  ├─ data_value = offer.bid_amount
  │  │  │
  │  │  └─ ... (more data rows)
  │  │
  │
  ├─ Queue Email to Seller (async)
  │  │
  │  ├─ Subject: "New offer on your iPhone 12"
  │  ├─ To: seller@email.com
  │  ├─ Content:
  │  │  - Buyer name
  │  │  - Offer amount
  │  │  - Pickup details
  │  │  - [Accept Offer] button
  │  │  - [Reject Offer] button
  │  │  - [View Dashboard] link
  │  │
  │
  ├─ Create AuditLog entry
  │  │
  │  ├─ INSERT INTO audit_logs:
  │  │  ├─ user_id = buyer ID
  │  │  ├─ resource_type = 'offer'
  │  │  ├─ resource_id = offer ID
  │  │  ├─ event_type = 'offer_created'
  │  │  └─ created_at = now()
  │  │
  │
  ↓
[Buyer Confirmation]
  │ "Your offer has been sent!"
  │ Redirect to /buyer/dashboard
  │
  ↓
[Seller Receives Offer]
  │
  ├─ Dashboard notification badge increments
  ├─ Email delivered to seller's inbox
  │
  ├─ Seller visits /listings/{listing}/offers
  │
  ↓
[Seller Reviews All Offers]
  │
  ├─ Display table:
  │  │ Buyer      | Amount | Date      | Action
  │  │ John Doe   | $150   | 2026-04-20 | Accept / Reject
  │  │ Jane Smith | $140   | 2026-04-21 | Accept / Reject
  │  │ Bob Jones  | $160   | 2026-04-22 | Accept / Reject
  │
  ↓
[Seller clicks "Accept" on one offer]
  │
  ↓
[OfferController@accept]
  │
  ├─ Update accepted offer:
  │  │ UPDATE offers
  │  │ SET status = 'accepted',
  │  │     responded_at = now()
  │  │ WHERE id = offer_id
  │
  ├─ Update listing to matched:
  │  │ UPDATE listings
  │  │ SET status = 'matched',
  │  │     matched_buyer_id = buyer_id,
  │  │     matched_at = now()
  │  │ WHERE id = listing_id
  │
  ├─ Reject all other pending offers:
  │  │ UPDATE offers
  │  │ SET status = 'rejected',
  │  │     responded_at = now()
  │  │ WHERE listing_id = listing_id
  │  │ AND id != accepted_offer_id
  │  │ AND status = 'pending'
  │
  ├─ Notify accepted buyer:
  │  │ INSERT INTO notifications
  │  │ type = 'offer_accepted'
  │  │ Email sent: "Your offer was accepted!"
  │
  ├─ Notify rejected buyers:
  │  │ For each rejected offer:
  │  │ INSERT INTO notifications
  │  │ type = 'offer_rejected'
  │  │ Email sent: "Your offer was declined"
  │
  ├─ Create AuditLog entries
  │  │ For acceptance, listing update, all rejections
  │
  ↓
END: Offer Accepted & Transaction Begins
```

---

## Transaction Completion & Impact Calculation Flow

```
START: After Offer Accepted
  │
  ├─ Buyer & Seller coordinate pickup (external)
  │
  ↓
[Seller marks "Picked Up"]
  │ Seller visits /listings/{id}
  │ Clicks "Mark as Picked Up"
  │
  ↓
[ListingController@markPickedUp]
  │
  ├─ UPDATE listings
  │  SET picked_up_at = now()
  │
  ├─ CREATE AuditLog entry
  │
  ↓
[Seller/Buyer confirms delivery]
  │ Buyer or seller marks item delivered
  │
  ↓
[ListingController@markDelivered]
  │
  ├─ UPDATE listings
  │  SET delivered_at = now(),
  │      status = 'completed'
  │
  ├─ UPDATE offers
  │  SET status = 'completed'
  │
  ↓
[IMPACT CALCULATION TRIGGERED]
  │
  ├─ Retrieve Listing:
  │  │ - carbon_footprint (kg)
  │  │ - estimated_weight (kg)
  │  │ - seller_id
  │
  ├─ Update Seller Impact Metrics:
  │  │
  │  ├─ Calculate seller impact:
  │  │  SELECT user_id, 
  │  │         SUM(carbon_footprint) as total_co2,
  │  │         SUM(estimated_weight) as total_weight,
  │  │         COUNT(*) as items_processed
  │  │  FROM listings
  │  │  WHERE user_id = seller_id
  │  │  AND status = 'completed'
  │  │
  │  ├─ UPDATE users
  │  │  SET total_co2_saved = calculated_sum,
  │  │      total_weight_diverted = calculated_weight,
  │  │      items_processed = count,
  │  │      total_impact_score = (co2 * weight_factor)
  │  │  WHERE id = seller_id
  │
  ├─ Create ImpactLog Entry:
  │  │
  │  ├─ INSERT INTO impact_logs:
  │  │  ├─ user_id = seller_id
  │  │  ├─ item_id = listing_id
  │  │  ├─ impact_type = 'device_sold'
  │  │  ├─ carbon_saved = listing.carbon_footprint
  │  │  ├─ weight_diverted = listing.estimated_weight
  │  │  ├─ created_at = now()
  │  │
  │
  ├─ Update Buyer Impact (if applicable):
  │  │ Similar calculation for buyer metrics
  │
  ├─ Send Completion Notifications:
  │  │
  │  ├─ To Seller: "Transaction completed!"
  │  ├─ To Buyer: "Item received! Please leave a review"
  │  │
  │
  ↓
[Review Prompts]
  │
  ├─ Seller can review Buyer:
  │  │ /reviews/create?type=buyer&user={buyer_id}
  │
  ├─ Buyer can review Seller:
  │  │ /reviews/create?type=seller&user={seller_id}
  │
  ├─ Review form includes:
  │  │ - Overall rating (1-5 stars)
  │  │ - Attribute ratings (communication, speed, etc.)
  │  │ - Text comment
  │
  ↓
[ReviewController@store]
  │
  ├─ INSERT INTO reviews:
  │  │ - reviewer_id, reviewee_id
  │  │ - rating, comment
  │  │ - reviewed_at = now()
  │
  ├─ INSERT INTO review_attributes (for each rating):
  │  │ - review_id
  │  │ - attribute_name ('communication', 'speed', etc.)
  │  │ - rating (1-5)
  │  │ COMPOSITE UNIQUE: (review_id, attribute_name)
  │
  ├─ Update User Average Rating:
  │  │ SELECT AVG(rating) FROM reviews
  │  │ WHERE reviewee_id = user_id
  │
  ↓
END: Transaction Finalized with Impact & Reviews
```

---

## Admin Verification Workflow Data Flow

```
START: New user registers locally
  │
  ├─ user.is_verified = false
  ├─ Admin dashboard shows: "5 unverified users"
  │
  ↓
[Admin visits /admin/users?filter=unverified]
  │
  ↓
[AdminController@users]
  │
  ├─ Query users:
  │  │ SELECT * FROM users
  │  │ WHERE is_verified = false
  │  │ AND deleted_at IS NULL
  │  │ ORDER BY created_at DESC
  │
  ├─ Display unverified queue:
  │  │ ┌─────────────────────────────────┐
  │  │ │ Unverified Users (5)            │
  │  │ ├─────────────────────────────────┤
  │  │ │ John Doe (buyer)                │
  │  │ │ Email: john@example.com         │
  │  │ │ Registered: 2026-04-18          │
  │  │ │ [Verify] [Reject] [Details]     │
  │  │ └─────────────────────────────────┘
  │
  ↓
[Admin clicks "Details" to review user]
  │
  ├─ Show user profile:
  │  │ - Name, Email, Role
  │  │ - Registration date
  │  │ - Associated listings (if any)
  │  │ - Associated offers (if any)
  │  │ - Email verified status
  │
  ↓
[Admin Decision]
  │
  ├─────────────────┬──────────────┐
  │                 │              │
  ↓                 ↓              ↓
[Verify User]   [Reject User]  [More Info]
  │                 │
  │                 ├─ Flag for review
  │                 ├─ Send message
  │                 └─ Wait for response
  │
  ├─ UPDATE users
  │  SET is_verified = true,
  │      email_verified_at = now()
  │  WHERE id = user_id
  │
  ├─ CREATE audit_log entry
  │  event_type = 'user_verified'
  │  changes = {is_verified: false → true}
  │
  ├─ Send notification to user
  │  type = 'account_verified'
  │  "Your account has been verified!"
  │
  ├─ UPDATE users
  │  SET deleted_at = now()
  │  WHERE id = user_id
  │
  ├─ CREATE audit_log entry
  │  event_type = 'user_rejected'
  │  changes = {deleted_at: NULL → now()}
  │
  ├─ Send notification to user
  │  type = 'account_rejected'
  │  "Your account was rejected"
  │
  ↓
[Admin Dashboard Updates]
  │
  ├─ Unverified count decreases
  ├─ Total users/verified split updates
  ├─ AuditLog shows new admin action
  │
  ↓
END: User verification workflow complete
```

---

## Email Notification Queue System

```
TRIGGER: Any event requiring email notification
  │
  ├─ user_registered (local)
  ├─ offer_created
  ├─ offer_accepted
  ├─ offer_rejected
  ├─ transaction_completed
  ├─ review_left
  ├─ password_reset_requested
  ├─ email_change_requested
  ├─ account_verified (admin)
  ├─ account_rejected (admin)
  │
  ↓
[Queue Job Created]
  │
  ├─ INSERT INTO jobs table:
  │  │ - queue: 'default'
  │  │ - payload: JSON with event details
  │  │ - attempts: 0
  │  │ - reserved_at: NULL
  │  │ - available_at: now()
  │  │ - created_at: now()
  │
  ↓
[Queue Worker Processes Job (async)]
  │
  ├─ Retrieve job from queue
  ├─ Render email template (Blade)
  ├─ Format email body
  │
  ├─ Send via configured driver:
  │  │ - SMTP (production)
  │  │ - Mailtrap (testing)
  │  │ - Database (fallback)
  │
  ├─ If successful:
  │  │ DELETE FROM jobs WHERE id = job_id
  │
  ├─ If failed:
  │  │ Increment attempts
  │  │ If attempts > max_retries:
  │  │   INSERT INTO failed_jobs
  │  │ Else:
  │  │   Re-queue for retry
  │
  ↓
END: Email delivered or queued for retry
```

---

## 3NF Normalization Benefits

### Before (Denormalized)
```sql
listings table:
- id, user_id, ... photos (JSON), carbon_footprint (computed)

reviews table:
- id, reviewer_id, ..., attributes (JSON)

notifications table:
- id, user_id, ..., data (JSON)

audit_logs table:
- id, user_id, ..., old_values (JSON), new_values (JSON)

users table:
- id, email, ..., password_reset_token, email_change_token, 
  email_change_requested_at, email_change_new_email
```

**Issues:** JSON parsing overhead, duplicate data, query difficulty, large row size

### After (3NF)
```sql
listings table:
- id, user_id, ... carbon_footprint (calculated)

listing_photos table:
- id, listing_id (FK), photo_url, sort_order
(One row per photo)

reviews table:
- id, reviewer_id, ..., (no attributes)

review_attributes table:
- id, review_id (FK), attribute_name, rating
(One row per attribute)

notifications table:
- id, user_id, ... (no data blob)

notification_data table:
- id, notification_id (FK), data_key, data_value
(One row per key-value pair)

audit_logs table:
- id, user_id, ... (no old_values/new_values)

audit_log_changes table:
- id, audit_log_id (FK), field_name, old_value, new_value
(One row per field change)

password_reset_tokens table:
- id, user_id (FK), token, created_at, expires_at

email_change_tokens table:
- id, user_id (FK), new_email, token, expires_at
```

**Benefits:**
- ✅ Single atomic values per column
- ✅ Efficient foreign key relationships
- ✅ Natural joins instead of JSON parsing
- ✅ Composite unique constraints for duplicates
- ✅ Cascade deletes for data cleanup
- ✅ Better indexing & query performance
- ✅ Easier to maintain & audit

---

**Architecture Documentation** | April 19, 2026 | E-Benta Production System
