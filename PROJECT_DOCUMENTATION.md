# E-Benta - Circular Economy E-Waste Marketplace

## 🌍 Project Overview

E-Benta is a Laravel-based marketplace for responsible electronic waste management, built on circular economy principles. The platform connects e-waste sellers with verified recyclers and buyers, enabling a sustainable alternative to landfill disposal.

## ✨ Key Features

### User Roles
- **Sellers**: Create listings for e-waste items and receive offers from buyers
- **Buyers/Recyclers**: Browse listings, submit offers, process devices, and track environmental impact
- **Admins**: Manage platform, verify buyers, monitor transactions, and generate analytics

### Core Functionality
1. **Smart Listing System**
   - Automatic weight-based carbon footprint calculation
   - AI-assisted pricing based on device category and condition
   - Multi-photo upload support
   - Three disposal options: Sell, Donate, or Recycle

2. **Matchmaking Algorithm**
   - Buyers browse available listings by category, condition, and price
   - Sellers receive and compare multiple offers
   - Transaction lock-in prevents double-booking

3. **Impact Tracking**
   - Real-time CO₂ savings calculation
   - Material recovery documentation (Gold, Copper, Plastic, Aluminum, Rare Earth)
   - Environmental impact scoring for users

4. **Digital Certificates**
   - Automatic certificate generation upon processing completion
   - Proof of responsible disposal
   - Unique verification tokens for authenticity

5. **Admin Dashboard**
   - Buyer account verification system
   - Transaction monitoring and reporting
   - System analytics and environmental impact metrics
   - Quarterly and yearly reports generation

## 🗄️ Database Schema

### Users Table (Extended)
```
- role (enum: seller, buyer, admin)
- is_verified (for buyer verification)
- business_name, business_description, phone
- total_impact_score, items_processed, total_weight_diverted, total_co2_saved
```

### Listings Table
```
- category, condition (working, minor_damage, major_damage, non_functional)
- description, estimated_weight, intended_action (sell, donate, recycle)
- suggested_price, photos (JSON), status, carbon_footprint
- matched_buyer_id, pickup tracking timestamps
```

### Offers Table
```
- bid_amount, proposed_method (repair, harvest, refine, dispose)
- proposed_pickup_date, pickup_location
- status (pending, accepted, rejected, completed)
```

### ImpactLog Table
```
- processing_method, device_weight
- co2_saved, landfill_diverted_weight, materials_recovered_weight
- Material breakdown: gold, copper, plastic, aluminum, rare_earth
- certificate_path, certificate_token, status
```

## � Entity Relationship Diagram (ERD)

To effectively manage the complex data structure of the E-Benta system, the developers implemented an Entity Relationship Diagram (ERD) as a central tool for database modeling. The ERD is a structured visual representation that defines how data entities are organized, connected, and interact within the system. By clearly outlining tables, attributes, primary keys, and foreign key relationships, the ERD enables the design of a normalized and consistent database that accurately reflects the real-world processes of e-waste marketplace management and circular economy operations.

Figure 3.4 presents the complete ERD of the E-Benta system, illustrating the relational schema and highlighting the interaction between different system modules through data exchange and dependencies. This diagram demonstrates the core entities—Users, Listings, Offers, and ImpactLogs—and their interconnections, which are essential for managing seller-buyer transactions, environmental impact tracking, and digital certificate generation. The ERD acts as a blueprint, guiding developers in defining how data is stored, accessed, and maintained throughout the system lifecycle. According to established database design principles, ERDs are essential in database design because they provide a clear visual representation of entities, attributes, and relationships, ensuring accurate identification of all required data components before implementation. This systematic modeling helps prevent design errors, maintain data integrity, and reduce redundancy—critical for a platform handling sensitive transaction and environmental impact data.

## �🚀 System Flow

### Stage A: Intake (Seller)
1. User registers as seller
2. Lists e-waste item with photos and description
3. System calculates environmental impact
4. Item becomes available for offers

### Stage B: Marketplace (Matchmaking)
1. Verified buyers browse available listings
2. Multiple buyers submit offers with processing methods
3. Sellers review and select best offer
4. Contract locked - item matched

### Stage C: Logistics
1. Buyer confirms pickup date and location
2. Item collected and marked "in transit"
3. Buyer receives item at their facility

### Stage D: Processing & Impact
1. Buyer reports processing method and materials recovered
2. System calculates environmental savings
3. Digital Certificate generated and issued
4. Seller receives proof of responsible disposal
5. Environmental metrics updated

## 📊 Environmental Impact Formula

$$\text{CO}_2 \text{ Saved} = \text{Device Weight (kg)} \times 15 \text{ (kg CO}_2\text{/kg device)}$$

This coefficient represents typical e-waste carbon footprint from manufacturing and transportation savings through proper recycling.

## 🔧 Technical Stack

- **Framework**: Laravel 12
- **Database**: MySQL
- **Frontend**: Bootstrap 5
- **Authentication**: Laravel built-in authentication
- **File Storage**: Local storage with public disk

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php (Registration, Login, Profile)
│   │   ├── ListingController.php (Seller listings management)
│   │   ├── OfferController.php (Buyer offers & browsing)
│   │   ├── ImpactController.php (Environmental calculations)
│   │   └── AdminController.php (Admin dashboard & analytics)
│   └── Middleware/
│       ├── CheckIfSeller.php
│       ├── CheckIfBuyer.php
│       └── CheckIfAdmin.php
├── Models/
│   ├── User.php (Extended with roles and impact metrics)
│   ├── Listing.php
│   ├── Offer.php
│   └── ImpactLog.php
database/
├── migrations/
│   ├── 2026_03_14_000003_add_role_to_users_table.php
│   ├── 2026_03_14_000004_create_listings_table.php
│   ├── 2026_03_14_000005_create_offers_table.php
│   └── 2026_03_14_000006_create_impact_logs_table.php
resources/
├── views/
│   ├── layouts/app.blade.php (Main layout)
│   ├── auth/ (Register, Login, Profile)
│   ├── listings/ (Browse, Create, Show, Edit)
│   ├── offers/ (Create, Show)
│   ├── seller/ (Dashboard)
│   ├── buyer/ (Dashboard, Pending verification)
│   └── admin/ (Dashboard, Verifications, Listings, Reports)
routes/
└── web.php (All application routes)
```

## 🔐 Role-Based Access Control

### Seller
- Create and manage listings
- View pending offers
- Accept/reject offers
- Track item status

### Buyer
- Browse available listings
- Submit offers with processing methods
- Accept pickup responsibility
- Report processing completion
- View environmental impact

### Admin
- Verify buyer accounts
- Monitor all listings and offers
- View system analytics
- Generate environmental reports
- Manage complaints and disputes

## 🛣️ Routes Overview

```
Public Routes:
  GET  /                          (Home)
  GET  /listings                  (Browse listings)
  GET  /listings/{listing}        (View listing detail)

Auth Routes:
  GET  /register                  (Registration form)
  POST /register                  (Submit registration)
  GET  /login                     (Login form)
  POST /login                     (Submit login)
  POST /logout                    (Logout)
  GET  /profile                   (View profile)
  PUT  /profile                   (Update profile)
  GET  /change-password           (Change password form)
  POST /change-password           (Submit password change)

Seller Routes:
  GET  /seller/dashboard                  (Dashboard)
  GET  /listings/create                   (Create listing form)
  POST /listings                          (Store listing)
  GET  /listings/{listing}/edit           (Edit form)
  PUT  /listings/{listing}                (Update listing)
  DELETE /listings/{listing}              (Delete listing)
  GET  /listings/{listing}/offers         (View offers for listing)

Buyer Routes:
  GET  /buyer/dashboard                   (Dashboard)
  GET  /offers/create/{listing}           (Create offer form)
  POST /offers                            (Store offer)
  GET  /offers/{offer}                    (View offer details)
  POST /offers/{offer}/accept             (Accept offer)
  POST /offers/{offer}/reject             (Reject offer)
  POST /offers/{offer}/mark-picked-up     (Confirm pickup)
  POST /offers/{offer}/update-status      (Report processing)
  GET  /certificates/{impactLog}          (View certificate)

Admin Routes:
  GET  /admin/dashboard                           (Dashboard)
  GET  /admin/verifications/pending               (Pending verifications)
  POST /admin/users/{user}/verify                 (Verify user)
  POST /admin/users/{user}/reject                 (Reject user)
  GET  /admin/listings                           (All listings)
  GET  /admin/offers                             (All offers)
  GET  /admin/impact-logs                        (Impact logs)
  GET  /admin/reports                            (Generate reports)
  GET  /admin/statistics                         (System statistics)
```

## 🎯 Key Models & Relationships

### User
- `hasMany` Listings (as seller)
- `hasMany` Offers (as buyer)
- `hasMany` ImpactLogs (as seller)
- `hasMany` ImpactLogs (as buyer)

### Listing
- `belongsTo` User (seller)
- `belongsTo` User (matched buyer)
- `hasMany` Offers
- `hasMany` ImpactLogs

### Offer
- `belongsTo` Listing
- `belongsTo` User (buyer)
- `hasMany` ImpactLogs

### ImpactLog
- `belongsTo` Listing
- `belongsTo` User (seller)
- `belongsTo` User (buyer)
- `belongsTo` Offer

## 🔧 Installation & Setup

```bash
# Install dependencies
composer install
npm install

# Set up environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# Seed admin user (optional)
php artisan tinker
> User::create(['name' => 'Admin', 'email' => 'admin@ebenta.com', 'role' => 'admin', 'is_verified' => true, 'password' => Hash::make('password')])

# Start development server
php artisan serve
npm run dev
```

## 📈 Future Enhancements

1. **Email Notifications** - Notification system for offers and status updates
2. **PDF Certificates** - Generate downloadable PDF certificates
3. **API** - RESTful API for mobile app integration
4. **Payment Processing** - Stripe integration for transactions
5. **Advanced Matching** - ML-based matching algorithm
6. **Ratings & Reviews** - User rating system
7. **Dispute Resolution** - Conflict resolution system
8. **Real-time Chat** - Seller-buyer communication
9. **Mobile App** - Native mobile application
10. **Blockchain** - Immutable transaction records

## 🌟 Environmental Impact Tracking

The system tracks:
- **CO₂ Emissions Prevented** (kg CO₂)
- **E-Waste Diverted** (kg)
- **Materials Recovered** (kg by type)
- **User Impact Scores**
- **System-wide Analytics**

## 📝 Notes for Developers

1. All migrations are timestamped and ordered for sequential execution
2. Role-based middleware is registered in `bootstrap/app.php`
3. Environmental calculations use conservative estimates
4. Certificate generation creates HTML files (implement PDF library for production)
5. File storage uses Laravel's public disk for photos
6. All timestamps are tracked for audit trail

## 📄 License

This project is built for sustainable e-waste management. All code is provided as-is.

---

**Built for a more sustainable future! ♻️**
