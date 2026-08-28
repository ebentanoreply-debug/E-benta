<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ImpactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SavedItemController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Api\DeviceModelController;
use App\Models\Listing;
use App\Models\User;
use App\Models\ImpactLog;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

// Public routes
Route::get('/', function () {
    $hasListings = Schema::hasTable('listings');
    $hasUsers = Schema::hasTable('users');
    $hasImpactLogs = Schema::hasTable('impact_logs');

    $featuredListings = $hasListings 
        ? Listing::where('status', 'available')->with(['seller', 'deviceType', 'listingPhotos'])->latest()->take(6)->get()
        : collect();

    $totalListings = $hasListings ? Listing::count() : 0;
    $totalUsers = $hasUsers ? User::count() : 0;
    $totalCarbonSaved = $hasImpactLogs ? ((float) ImpactLog::sum('co2_saved') ?: ($hasListings ? (float) Listing::sum('carbon_footprint') : 0)) : 0;
    $totalWeightDiverted = $hasImpactLogs ? ((float) ImpactLog::sum('landfill_diverted_weight') ?: ($hasListings ? Listing::where('status', 'completed')->count() * 1.5 : 0)) : 0;

    return view('welcome', compact('featuredListings', 'totalListings', 'totalUsers', 'totalCarbonSaved', 'totalWeightDiverted'));
})->name('home');

Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.forgot');
    Route::post('/forgot-password', [AuthController::class, 'sendForgotPasswordEmail'])->name('password.email');
    Route::get('/reset-password/verify', [AuthController::class, 'showVerifyResetCodeForm'])->name('password.reset');
    Route::post('/reset-password/verify', [AuthController::class, 'verifyResetCode'])->name('password.verify-code');
    Route::get('/reset-password/new', [AuthController::class, 'showSetNewPasswordForm'])->name('password.new');
    Route::post('/reset-password/new', [AuthController::class, 'setNewPassword'])->name('password.update-new');
    Route::get('/reset-password/{token?}', function (\Illuminate\Http\Request $request) {
        return redirect()->route('password.reset', $request->query());
    });

    // Google OAuth routes
    Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
    Route::get('/auth/google/confirm', [GoogleAuthController::class, 'showConfirmation'])->name('auth.google.confirm');
    Route::post('/auth/google/confirm', [GoogleAuthController::class, 'confirmRegistration'])->name('auth.google.confirm.post');
    
});

// Google OAuth role selection (guest)
Route::middleware('guest')->group(function () {
    Route::get('/auth/google/select-role', [GoogleAuthController::class, 'showSelectRole'])->name('auth.google.select-role');
    Route::post('/auth/google/complete-registration', [GoogleAuthController::class, 'completeRegistration'])->name('auth.google.complete-registration');
    // Redirect GET requests to this endpoint back to role selection
    Route::get('/auth/google/complete-registration', function () {
        return redirect('/auth/google/select-role')->with('error', 'Please use the form to complete registration.');
    });
});

// Email verification routes (accessible by pending guest registrations & logged in users)
Route::get('/verify-email', [EmailVerificationController::class, 'show'])->name('verification.notice');
Route::post('/verify-email', [EmailVerificationController::class, 'verify'])->name('verification.verify');
Route::post('/verify-email/resend', [EmailVerificationController::class, 'resend'])->name('verification.resend');
Route::get('/register/set-password', [EmailVerificationController::class, 'showSetPasswordForm'])->name('register.set-password');
Route::post('/register/set-password', [EmailVerificationController::class, 'savePasswordAndComplete'])->name('register.save-password');

Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Authenticated user routes
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/avatar', [AuthController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::delete('/profile/avatar', [AuthController::class, 'deleteAvatar'])->name('profile.avatar.delete');
    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('password.change.update');
    Route::get('/change-email', [AuthController::class, 'showEmailChangeRequestForm'])->name('email.change.request');
    Route::post('/change-email', [AuthController::class, 'sendEmailChangeRequest'])->name('email.change.send');
    Route::get('/verify-email-change/{token}', [AuthController::class, 'showVerifyEmailChangeForm'])->name('email.change.verify');
    Route::post('/verify-email-change', [AuthController::class, 'verifyEmailChange'])->name('email.change.confirm');

    // Settings routes
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::put('/settings/notifications', [SettingsController::class, 'updateNotifications'])
        ->name('settings.notifications.update');
    Route::put('/settings/privacy', [SettingsController::class, 'updatePrivacy'])
        ->name('settings.privacy.update');
    Route::put('/settings/payments', [SettingsController::class, 'updatePayments'])
        ->name('settings.payments.update');
    Route::put('/settings/seller', [SettingsController::class, 'updateSellerProfile'])
        ->name('settings.seller.update');
    Route::post('/settings/id-verification', [SettingsController::class, 'submitIdVerification'])
        ->name('settings.id-verification.submit');
    Route::put('/settings/preferences', [SettingsController::class, 'updatePreferences'])
        ->name('settings.preferences.update');

    // Address management routes
    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::get('/addresses/create', [AddressController::class, 'create'])->name('addresses.create');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::get('/addresses/{address}', [AddressController::class, 'show'])->name('addresses.show');
    Route::get('/addresses/{address}/edit', [AddressController::class, 'edit'])->name('addresses.edit');
    Route::put('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::post('/addresses/{address}/mark-primary', [AddressController::class, 'markAsPrimary'])->name('addresses.mark-primary');
    Route::get('/api/addresses/by-type', [AddressController::class, 'getByType'])->name('api.addresses.by-type');

    // Seller routes
    Route::middleware('seller')->group(function () {
        Route::get('/seller/dashboard', [ListingController::class, 'sellerDashboard'])->name('seller.dashboard');
        Route::get('/seller/my-listings', [ListingController::class, 'sellerListings'])->name('seller.listings');
        Route::get('/seller/sales-analytics', [OfferController::class, 'sellerSalesAnalytics'])->name('seller.sales-analytics');
        Route::get('/seller/transaction-history', [OfferController::class, 'sellerTransactionHistory'])->name('seller.transaction-history');
        Route::get('/listings/create', [ListingController::class, 'create'])->name('listings.create');
        Route::post('/listings', [ListingController::class, 'store'])->name('listings.store');
        Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->name('listings.edit');
        Route::put('/listings/{listing}', [ListingController::class, 'update'])->name('listings.update');
        Route::post('/listings/{listing}/withdraw', [ListingController::class, 'withdraw'])->name('listings.withdraw');
        Route::get('/listings/{listing}/offers', [ListingController::class, 'getOffers'])->name('listings.offers');
    });

    // Buyer routes
    Route::middleware('buyer')->group(function () {
        Route::get('/buyer/dashboard', [OfferController::class, 'buyerDashboard'])->name('buyer.dashboard');
        Route::get('/buyer/transaction-history', [OfferController::class, 'buyerTransactionHistory'])->name('buyer.transaction-history');
        Route::get('/buyer/saved-items', [SavedItemController::class, 'index'])->name('buyer.saved-items');
        Route::post('/buyer/saved-items/{listing}', [SavedItemController::class, 'store'])->name('buyer.saved-items.store');
        Route::delete('/buyer/saved-items/{listing}', [SavedItemController::class, 'destroy'])->name('buyer.saved-items.destroy');
        Route::get('/offers/create/{listing}', [OfferController::class, 'create'])->name('offers.create');
        Route::post('/offers/{offer}/mark-picked-up', [OfferController::class, 'markPickedUp'])->name('offers.mark-picked-up');
        Route::post('/offers/{offer}/update-status', [OfferController::class, 'updateProcessingStatus'])->name('offers.update-status');
        Route::post('/offers/{offer}/cancel', [OfferController::class, 'cancel'])->name('offers.cancel');
        Route::post('/listings/{listing}/mark-delivered', [ListingController::class, 'markDelivered'])->name('listings.mark-delivered');
        Route::get('/offers/search', [OfferController::class, 'search'])->name('offers.search');
        Route::get('/offers/by-status', [OfferController::class, 'getOffersByStatus'])->name('offers.by-status');
    });

    // Offer routes - accessible to authenticated users (controller checks authorization)
    Route::post('/offers/{listing}', [OfferController::class, 'store'])->name('offers.store');
    Route::get('/offers/{offer}', [OfferController::class, 'show'])->name('offers.show');
    Route::post('/offers/{offer}/accept', [OfferController::class, 'accept'])->name('offers.accept');
    Route::post('/offers/{offer}/reject', [OfferController::class, 'reject'])->name('offers.reject');

    // Chat & Messaging routes
    Route::get('/messages', [ChatController::class, 'inbox'])->name('messages.index');
    Route::get('/offers/{offer}/messages', [ChatController::class, 'fetch'])->name('offers.messages.fetch');
    Route::post('/offers/{offer}/messages', [ChatController::class, 'store'])->name('offers.messages.store');

    // Review routes
    Route::get('/reviews/create/{offer}', [ReviewController::class, 'create'])->name('reviews.create')->middleware('auth');
    Route::post('/reviews/{offer}', [ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');
    Route::get('/reviews/{review}', [ReviewController::class, 'show'])->name('reviews.show');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy')->middleware('auth');
    Route::post('/reviews/{review}/report', [ReviewController::class, 'report'])->name('reviews.report')->middleware('auth');
    Route::get('/users/{user}/reviews', [ReviewController::class, 'userReviews'])->name('reviews.user');

    // Report/Flag routes for users
    Route::get('/report', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/report', [ReportController::class, 'store'])->name('reports.store');
    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/dashboard/export', [AdminController::class, 'exportDashboardReport'])->name('admin.dashboard.export');
        Route::get('/admin/verifications/pending', [AdminController::class, 'pendingVerifications'])->name('admin.pending-verifications');
        Route::post('/admin/users/{user}/verify', [AdminController::class, 'verifyUser'])->name('admin.verify-user');
        Route::post('/admin/users/{user}/reject', [AdminController::class, 'rejectUser'])->name('admin.reject-user');
        Route::get('/admin/listings', [AdminController::class, 'allListings'])->name('admin.listings');
        Route::get('/admin/offers', [AdminController::class, 'allOffers'])->name('admin.offers');
        Route::get('/admin/impact-logs', [AdminController::class, 'impactLogs'])->name('admin.impact-logs');
        Route::get('/admin/generate-reports', [AdminController::class, 'generateReport'])->name('admin.generate-reports');
        Route::get('/admin/statistics', [AdminController::class, 'getStatistics'])->name('admin.statistics');
        
        // Audit logs routes
        Route::get('/admin/audit-logs', [AuditLogController::class, 'index'])->name('admin.audit-logs.index');
        Route::get('/admin/audit-logs/{auditLog}', [AuditLogController::class, 'show'])->name('admin.audit-logs.show');
        Route::get('/admin/audit-logs/user/{userId}', [AuditLogController::class, 'userLogs'])->name('admin.audit-logs.user');
        Route::get('/admin/audit-logs/model/{modelType}/{modelId}', [AuditLogController::class, 'modelLogs'])->name('admin.audit-logs.model');
        Route::get('/admin/audit-logs/export', [AuditLogController::class, 'export'])->name('admin.audit-logs.export');
        Route::post('/admin/audit-logs/cleanup', [AuditLogController::class, 'cleanup'])->name('admin.audit-logs.cleanup');

        // Reports/Flags management routes (admin)
        Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports.index');
        Route::get('/admin/reports/{report}', [ReportController::class, 'show'])->name('admin.reports.show');
        Route::post('/admin/reports/{report}/under-review', [ReportController::class, 'markUnderReview'])->name('admin.reports.under-review');
        Route::post('/admin/reports/{report}/resolve', [ReportController::class, 'resolve'])->name('admin.reports.resolve');
        Route::post('/admin/reports/{report}/dismiss', [ReportController::class, 'dismiss'])->name('admin.reports.dismiss');
        Route::get('/api/admin/reports/statistics', [ReportController::class, 'statistics'])->name('api.admin.reports.statistics');
    });

    // Impact & Certificate routes (controller enforces buyer, seller, or admin ownership)
    Route::get('/certificates/{impactLog}', [ImpactController::class, 'showCertificate'])->name('certificates.show');

    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{notification}/open', [NotificationController::class, 'open'])->name('notifications.open');
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
    Route::get('/notifications/recent', [NotificationController::class, 'recent'])->name('notifications.recent');
    Route::post('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // API routes for device references
    Route::get('/api/device-models/{typeId}', [DeviceModelController::class, 'byType']);
});

// Public listing show route - AFTER all specific routes
Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('listings.show');

// Public user profile route - show seller/user reviews and details
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
