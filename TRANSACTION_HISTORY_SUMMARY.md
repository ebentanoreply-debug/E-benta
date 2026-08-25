# E-Benta Transaction History & Offer Tracking System

## Overview
The E-Benta platform tracks transactions through the relationship between **Offers**, **Impact Logs**, and **User Activity**. The transaction lifecycle flows from offer submission → acceptance → pickup → processing → certification.

---

## 1. OFFER MODEL STRUCTURE

**File:** [app/Models/Offer.php](app/Models/Offer.php)

### Table Schema
```sql
CREATE TABLE offers (
    id BIGINT PRIMARY KEY,
    listing_id BIGINT FOREIGN KEY,
    buyer_id BIGINT FOREIGN KEY,
    bid_amount DECIMAL(10,2),
    proposed_method ENUM('repair', 'harvest', 'refine', 'dispose'),
    notes TEXT NULLABLE,
    proposed_pickup_date DATETIME,
    pickup_location TEXT NULLABLE,
    status ENUM('pending', 'accepted', 'rejected', 'cancelled', 'completed'),
    responded_at TIMESTAMP NULLABLE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    deleted_at TIMESTAMP NULLABLE
);
```

### Offer Attributes
| Field | Type | Description |
|-------|------|-------------|
| `bid_amount` | Decimal(10,2) | Amount offered for the item |
| `proposed_method` | Enum | Processing method: repair, harvest, refine, or dispose |
| `proposed_pickup_date` | DateTime | When buyer proposes to pick up item |
| `pickup_location` | Text | Location for item pickup |
| `status` | Enum | Current offer state |
| `responded_at` | Timestamp | When seller responded to offer |

### Offer Relationships
```php
- listing(): BelongsTo(Listing)        // Item being offered for
- buyer(): BelongsTo(User)             // Buyer who made the offer
- impactLog(): HasMany(ImpactLog)      // Transaction history after completion
- reviews(): HasMany(Review)           // Reviews left by/for both parties
- reports(): MorphMany(Report)         // Abuse/issue reports
```

### Offer Status States

| Status | Flow | Description |
|--------|------|-------------|
| **pending** | Initial | Waiting for seller response |
| **accepted** | After seller approves | Seller accepted the offer, listing marked as matched |
| **rejected** | Seller declines | Offer rejected, buyer can make another offer |
| **cancelled** | Offer revoked | Buyer or system cancelled the offer |
| **completed** | After processing | Full transaction complete, impact log created |

### Helper Methods
```php
- isPending(): bool          // Check if offer is pending
- isAccepted(): bool         // Check if offer is accepted
- isCompleted(): bool        // Check if offer is completed
- accept(): bool             // Accept offer & update listing status
- reject(): bool             // Reject offer
- complete(): bool           // Mark as completed
```

---

## 2. OFFER LIFECYCLE & TRANSACTION FLOW

```
┌─────────────────────────────────────────────────────────────┐
│                    OFFER LIFECYCLE                          │
└─────────────────────────────────────────────────────────────┘

1. CREATION
   └─> Buyer submits offer on available listing
   └─> Status: "pending"
   └─> Notification sent to seller

2. SELLER RESPONSE
   ├─> ACCEPT
   │   └─> Offer status → "accepted"
   │   └─> Listing status → "matched"
   │   └─> matched_buyer_id & matched_at set
   │   └─> All other pending offers rejected
   │   └─> Notification sent to buyer
   │
   └─> REJECT
       └─> Offer status → "rejected"
       └─> responded_at timestamp set
       └─> Notification sent to buyer

3. BUYER PICKUP
   └─> Buyer marks item as picked up
   └─> Listing status → "in_transit"
   └─> picked_up_at timestamp set

4. PROCESSING
   └─> Buyer updates processing status
   └─> Processing method recorded
   └─> Material breakdown documented
   └─> Listing status → "processed"
   └─> processed_at timestamp set

5. IMPACT CERTIFICATION
   └─> ImpactLog created with environmental metrics
   └─> Offer status → "completed"
   └─> Carbon footprint calculated
   └─> Materials recovered documented
   └─> Impact certificate generated & certified
   └─> Seller metrics updated
```

---

## 3. IMPACT LOG MODEL (TRANSACTION HISTORY)

**File:** [app/Models/ImpactLog.php](app/Models/ImpactLog.php)

### Table Schema
```sql
CREATE TABLE impact_logs (
    id BIGINT PRIMARY KEY,
    listing_id BIGINT FOREIGN KEY,
    seller_id BIGINT FOREIGN KEY,
    buyer_id BIGINT FOREIGN KEY,
    offer_id BIGINT FOREIGN KEY UNIQUE,
    device_category VARCHAR(255),
    device_weight DECIMAL(5,2),                -- in kg
    processing_method ENUM('repair', 'harvest', 'refine', 'dispose'),
    co2_saved DECIMAL(10,2),                   -- in kg CO2
    landfill_diverted_weight DECIMAL(10,2),    -- in kg
    materials_recovered_weight DECIMAL(10,2),  -- in kg
    gold_recovered DECIMAL(5,4),                -- in kg
    copper_recovered DECIMAL(5,2),              -- in kg
    plastic_recovered DECIMAL(5,2),             -- in kg
    aluminum_recovered DECIMAL(5,2),            -- in kg
    rare_earth_recovered DECIMAL(5,4),          -- in kg
    certificate_path VARCHAR(255) NULLABLE,
    certificate_token VARCHAR(255) NULLABLE UNIQUE,
    status ENUM('pending', 'verified', 'certified'),
    certified_at TIMESTAMP NULLABLE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    deleted_at TIMESTAMP NULLABLE
);
```

### Impact Log Relationships
```php
- listing(): BelongsTo(Listing)    // The item processed
- seller(): BelongsTo(User)        // Seller of the item
- buyer(): BelongsTo(User)         // Buyer/processor
- offer(): BelongsTo(Offer)        // Related offer
```

### Environmental Metrics Tracked
- **CO2 Saved:** 15 kg CO2 per kg of e-waste diverted
- **Landfill Diversion:** Total weight kept from landfill
- **Materials Recovered:** Individual material weights (gold, copper, plastic, aluminum, rare earth)

### Helper Methods
```php
- getTotalMaterialsRecovered(): float     // Sum of all materials
- getMaterialBreakdown(): array           // Structured material data
- isCertified(): bool                     // Check certification status
- certify(): bool                         // Mark as certified
- generateCertificateToken(): string      // Create unique cert token
```

---

## 4. USER MODEL - TRANSACTION TRACKING

**File:** [app/Models/User.php](app/Models/User.php)

### User Attributes for Transaction Tracking
```php
protected $fillable = [
    'total_impact_score',      // Environmental impact contribution
    'items_processed',         // Number of items processed
    'total_weight_diverted',   // Total kg kept from landfill
    'total_co2_saved',         // Total CO2 equivalents saved
];
```

### User Relationships for Transactions
```php
- listings(): HasMany(Listing)              // Items listed as seller
- offers(): HasMany(Offer)                  // Offers made as buyer
- sellerImpactLogs(): HasMany(ImpactLog)   // Transaction history as seller
- buyerImpactLogs(): HasMany(ImpactLog)    // Transaction history as buyer
- reviewsGiven(): HasMany(Review)          // Reviews left by this user
- reviewsReceived(): HasMany(Review)       // Reviews received from others
```

### User Transaction Methods
```php
- getAverageRating(): float              // Average seller/buyer rating (0-5)
- getTotalReviews(): int                 // Count of reviews received
- isBuyer(): bool                        // Check if user is registered buyer
- isSeller(): bool                       // Check if user is registered seller
```

### User Impact Metrics Query
```php
// Get seller's total environmental impact
$seller->sellerImpactLogs()
    ->where('status', 'certified')
    ->sum('co2_saved')

// Get buyer's transaction history
$buyer->buyerImpactLogs()
    ->with(['listing', 'seller'])
    ->paginate(10)
```

---

## 5. ROUTES - TRANSACTION & OFFER MANAGEMENT

**File:** [routes/web.php](routes/web.php)

### Buyer Routes (Protected with `buyer` middleware)
```php
GET    /buyer/dashboard                    // View available listings & submitted offers
GET    /offers/create/{listing}            // Form to submit offer
POST   /offers/{offer}/mark-picked-up      // Mark item as picked up
POST   /offers/{offer}/update-status       // Update processing status & generate impact log
GET    /offers/search                      // Search listings with filters
GET    /offers/by-status                   // Filter offers by status (pending/accepted/completed)
```

### Seller Routes (Protected with `seller` middleware)
```php
GET    /seller/dashboard                   // View seller's listings
GET    /listings/{listing}/offers          // View all offers for a listing
```

### Offer Routes (Protected with `auth` middleware - controller checks authorization)
```php
POST   /offers/{listing}                   // Store new offer
GET    /offers/{offer}                     // View offer details
POST   /offers/{offer}/accept              // Accept an offer (seller only)
POST   /offers/{offer}/reject              // Reject an offer (seller only)
```

### Review Routes (Transaction feedback)
```php
GET    /reviews/create/{offer}             // Form to leave review
POST   /reviews/{offer}                    // Store review
GET    /reviews/{review}                   // View review
GET    /users/{user}/reviews               // View all reviews for user
DELETE /reviews/{review}                   // Delete review
POST   /reviews/{review}/report            // Report problematic review
```

### Admin Routes - Transaction Management
```php
GET    /admin/offers                       // View all offers
GET    /admin/impact-logs                  // View transaction impact history
GET    /admin/statistics                   // Transaction statistics
```

---

## 6. CONTROLLERS - TRANSACTION MANAGEMENT

### OfferController

#### Key Methods
```php
buyerDashboard()               // Get available listings & buyer's offers
create(Listing)                // Show offer creation form
store(Request, Listing)        // Validate & create offer, notify seller
show(Offer)                    // View offer details
accept(Offer)                  // Accept offer, update listing, notify buyer
reject(Offer)                  // Reject offer, notify buyer
markPickedUp(Offer)            // Mark item picked up, update listing status
updateProcessingStatus(Request, Offer)  // Update processing, create ImpactLog
search(Request)                // Filter available listings
getOffersByStatus(Request)     // Get offers by status for buyer
```

#### Validation Rules for offer.store()
```php
'bid_amount' => 'required|numeric|min:0.01'
'proposed_method' => 'required|in:repair,harvest,refine,dispose'
'proposed_pickup_date' => 'required|date|after:today'
'pickup_location' => 'required|string|max:255'
'notes' => 'nullable|string|max:500'
```

### ImpactController

#### Key Methods
```php
createImpactLog(Offer, array)  // Create impact log after processing
generateCertificate(ImpactLog)  // Generate environmental certificate
showCertificate(ImpactLog)      // Display certificate
getAdminAnalytics()             // Transaction analytics for admin
getSellerImpact(User)           // Get seller's transaction impact metrics
```

---

## 7. LISTINGS STATUSES & TRANSACTION STATES

**File:** [app/Models/Listing.php](app/Models/Listing.php)

```php
protected $fillable = [
    'status',              // Transaction state
    'matched_buyer_id',    // Which buyer got it
    'matched_at',          // When offer was accepted
    'pickup_scheduled_at', // When pickup is scheduled
    'picked_up_at',        // When item was picked up
    'processed_at',        // When item completed processing
];
```

### Listing Status Flow
| Status | Meaning | Transaction Stage |
|--------|---------|-------------------|
| **available** | Open for offers | No active offer |
| **matched** | Offer accepted | Offer accepted, waiting for pickup |
| **in_transit** | Buyer picked up | Buyer has item, going to processing |
| **processed** | Item processed | Processing complete, impact logged |
| **withdrawn** | Seller cancelled | Listing removed from marketplace |

---

## 8. REVIEW MODEL - TRANSACTION FEEDBACK

**File:** [app/Models/Review.php](app/Models/Review.php)

### Review Attributes
```php
protected $fillable = [
    'reviewer_id',      // Who left the review
    'reviewee_id',      // Who is being reviewed
    'offer_id',         // Which transaction this is about
    'rating',           // 1-5 stars
    'title',            // Review title
    'comment',          // Review text
    'review_type',      // 'buyer' or 'seller'
    'attributes',       // JSON: communication, professionalism, etc.
    'is_verified',      // Confirmed transaction participant
];
```

### Review Relationships
```php
- reviewer(): BelongsTo(User)    // Person who left review
- reviewee(): BelongsTo(User)    // Person being reviewed
- offer(): BelongsTo(Offer)      // Transaction being reviewed
```

### Queryable Methods
```php
- getStarRating(): string          // Display stars (★★★☆☆)
- getRatingPercentage(): float     // 0-100 percentage
- getReviewTypeLabel(): string     // "Buyer Review" or "Seller Review"
- getAttributesDisplay(): array    // Formatted attribute labels
- scopeForUser($userId)            // Reviews for specific user
- scopeRecent($days)               // Recent reviews (default 30 days)
```

---

## 9. AUDIT & NOTIFICATION SYSTEM

### AuditLogger Service
Tracks all transaction-related changes:
```php
- logCreate()                      // Log offer creation
- logOfferStatusChange()           // Log status changes
- updateSellerImpact()             // Log seller metrics update
```

### Notification Types
- `offer_received` - New offer submitted
- `offer_accepted` - Offer accepted by seller
- `offer_rejected` - Offer rejected
- Impact certificate ready

---

## 10. EXISTING VIEWS & TEMPLATES

**Current Views (Empty - Frontend Not Implemented):**
- `resources/views/buyer/dashboard`
- `resources/views/buyer/pending-verification`
- `resources/views/buyer/offers`
- `resources/views/offers/create`
- `resources/views/offers/show`
- `resources/views/listings/search-results`

**Note:** No views for transaction history currently exist. All routes are API-ready via controllers.

---

## 11. KEY TRANSACTION QUERIES

### Get user's completed transactions
```php
// Seller's completed sales
$seller->sellerImpactLogs()
    ->where('status', 'certified')
    ->with(['listing', 'buyer', 'offer'])
    ->orderByDesc('created_at')
    ->paginate(15)

// Buyer's completed purchases
$buyer->buyerImpactLogs()
    ->where('status', 'certified')
    ->with(['listing', 'seller', 'offer'])
    ->orderByDesc('created_at')
    ->paginate(15)
```

### Get offer by status
```php
Offer::where('buyer_id', $userId)
    ->where('status', 'accepted')
    ->with(['listing.seller', 'listing.deviceType'])
    ->get()
```

### Get total user impact
```php
$user->update([
    'total_co2_saved' => $user->sellerImpactLogs()->sum('co2_saved'),
    'total_weight_diverted' => $user->sellerImpactLogs()->sum('landfill_diverted_weight'),
    'items_processed' => $user->sellerImpactLogs()->count(),
]);
```

---

## 12. DATABASE RELATIONSHIPS DIAGRAM

```
USER
├─ id (PK)
├─ name, email, role
├─ total_impact_score
├─ items_processed
├─ total_weight_diverted
├─ total_co2_saved
└─ Relationships:
   ├─ listings (1:N as seller)
   ├─ offers (1:N as buyer)
   ├─ sellerImpactLogs (1:N)
   ├─ buyerImpactLogs (1:N)
   ├─ reviewsGiven (1:N)
   └─ reviewsReceived (1:N)

LISTING
├─ id (PK)
├─ user_id (FK) → USER (seller)
├─ matched_buyer_id (FK) → USER
├─ status (available|matched|in_transit|processed|withdrawn)
├─ matched_at, picked_up_at, processed_at
└─ Relationships:
   ├─ offers (1:N)
   ├─ impactLog (1:N)
   └─ seller (M:1 to USER)

OFFER
├─ id (PK)
├─ listing_id (FK) → LISTING
├─ buyer_id (FK) → USER
├─ bid_amount
├─ proposed_method (repair|harvest|refine|dispose)
├─ status (pending|accepted|rejected|cancelled|completed)
├─ responded_at
└─ Relationships:
   ├─ listing (M:1)
   ├─ buyer (M:1)
   ├─ impactLog (1:N)
   └─ reviews (1:N)

IMPACT_LOG
├─ id (PK)
├─ listing_id (FK) → LISTING
├─ seller_id (FK) → USER
├─ buyer_id (FK) → USER
├─ offer_id (FK) → OFFER (UNIQUE)
├─ device_weight, processing_method
├─ co2_saved, landfill_diverted_weight
├─ gold|copper|plastic|aluminum|rare_earth_recovered
├─ certificate_token
├─ status (pending|verified|certified)
└─ Relationships:
   ├─ offer (M:1)
   ├─ seller (M:1)
   └─ buyer (M:1)

REVIEW
├─ id (PK)
├─ reviewer_id (FK) → USER
├─ reviewee_id (FK) → USER
├─ offer_id (FK) → OFFER
├─ rating (1-5)
├─ review_type (buyer|seller)
├─ attributes (JSON)
└─ Relationships:
   ├─ reviewer (M:1)
   ├─ reviewee (M:1)
   └─ offer (M:1)
```

---

## 13. SUMMARY & RECOMMENDATIONS

### Current Capabilities
✅ Full offer management (create, accept, reject, complete)
✅ Transaction tracking via ImpactLog with environmental metrics
✅ User profile metrics (impact score, items processed)
✅ Review/rating system for transaction feedback
✅ Audit logging for all transaction changes
✅ Environmental certificate generation

### Missing Features (For Future Implementation)
- [ ] User Dashboard views showing transaction history
- [ ] Transaction detail pages with impact certificates
- [ ] Buyer/Seller profile pages with transaction stats
- [ ] Transaction analytics dashboard
- [ ] Email notifications for status updates
- [ ] Export transaction reports (CSV/PDF)
- [ ] Advanced filtering for transaction search
- [ ] Dispute resolution system for transactions
