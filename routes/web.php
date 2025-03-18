<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\ParticipationRequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NewsletterController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [WelcomeController::class, 'index']);

// مسارات متاحة للجميع
Route::get('/map', [MapController::class, 'index'])->name('map');
Route::get('/map/saved', [MapController::class, 'savedLocations'])->name('map.saved');
Route::get('/api/locations', [MapController::class, 'getLocations'])->name('api.locations');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/debug', [ProfileController::class, 'debug'])->name('profile.debug');
    
    // مسارات النشاطات والأحداث
    Route::get('/activities', [App\Http\Controllers\ActivityController::class, 'index'])->name('activities.index');
    Route::get('/events', [App\Http\Controllers\EventController::class, 'index'])->name('events.index');
    
    // مسارات الحملات التطوعية
    Route::get('/ads', [AdController::class, 'index'])->name('ads.index');
    Route::get('/ads/create', [AdController::class, 'create'])->middleware('can:create-campaign')->name('ads.create');
    Route::post('/ads', [AdController::class, 'store'])->middleware('can:create-campaign')->name('ads.store');
    Route::get('/ads/{ad}', [AdController::class, 'show'])->name('ads.show');
    Route::get('/ads/{ad}/edit', [AdController::class, 'edit'])->middleware('can:edit-campaign')->name('ads.edit');
    Route::put('/ads/{ad}', [AdController::class, 'update'])->middleware('can:edit-campaign')->name('ads.update');
    Route::delete('/ads/{ad}', [AdController::class, 'destroy'])->middleware('can:delete-campaign')->name('ads.destroy');
    
    // مسارات التبرع للحملات
    Route::get('/ads/{ad}/donate', [AdController::class, 'showDonateForm'])->name('ads.donate');
    Route::post('/ads/{ad}/donate', [AdController::class, 'donate'])->name('ads.donate.store');
    Route::get('/ads/demo/donate', function() { return view('ads.demo'); })->name('ads.demo');
    
    // مسارات التعليق على الحملات
    Route::post('/ads/{ad}/comment', [AdController::class, 'comment'])->name('ads.comment');
    Route::put('/comments/{comment}', [AdController::class, 'updateComment'])->name('comments.update');
    Route::delete('/comments/{comment}', [AdController::class, 'deleteComment'])->name('comments.delete');

    // مسارات فرص التطوع
    Route::resource('job-offers', JobOfferController::class);
    Route::post('/job-offers/{jobOffer}/request', [JobOfferController::class, 'requestParticipation'])
        ->name('job-offers.request');
        
    // مسارات طلبات المشاركة
    Route::get('/participation-requests', [ParticipationRequestController::class, 'index'])
        ->middleware('can:viewAny,App\Models\ParticipationRequest')
        ->name('participation-requests.index');
    Route::get('/participation-requests/{participationRequest}', [ParticipationRequestController::class, 'show'])
        ->name('participation-requests.show');
    Route::post('/participation-requests/{participationRequest}/status', [ParticipationRequestController::class, 'updateStatus'])
        ->name('participation-requests.update-status');
    Route::get('/my-participation-requests', [ParticipationRequestController::class, 'myRequests'])
        ->name('participation-requests.my');

    // مسارات المنظمات
    Route::resource('organizations', OrganizationController::class);
    Route::post('/organizations/{organization}/join', [OrganizationController::class, 'join'])->name('organizations.join');
    Route::delete('/organizations/{organization}/leave', [OrganizationController::class, 'leave'])->name('organizations.leave');
    Route::post('/organizations/{organization}/add-member', [OrganizationController::class, 'addMember'])->name('organizations.add-member');
    Route::delete('/organizations/{organization}/remove-member', [OrganizationController::class, 'removeMember'])->name('organizations.remove-member');
    Route::put('/organizations/{organization}/update-member-role', [OrganizationController::class, 'updateMemberRole'])->name('organizations.update-member-role');
    Route::post('/organizations/{organization}/verify', [OrganizationController::class, 'verifyOrganization'])->name('organizations.verify');

    // مسارات النشرة البريدية
    Route::post('/newsletter/subscribe', [App\Http\Controllers\NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
    Route::get('/newsletter/unsubscribe/{email}', [App\Http\Controllers\NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

    // مسارات الدعم والمساعدة
    Route::get('/faq', [App\Http\Controllers\SupportController::class, 'faq'])->name('support.faq');
    Route::get('/terms', [App\Http\Controllers\SupportController::class, 'terms'])->name('support.terms');
    Route::get('/privacy', [App\Http\Controllers\SupportController::class, 'privacy'])->name('support.privacy');
    Route::get('/technical-support', [App\Http\Controllers\SupportController::class, 'technical'])->name('support.technical');
    Route::post('/support-send', [App\Http\Controllers\SupportController::class, 'send'])->name('support.send');

    // مسارات نظام التذاكر
    Route::get('/my-tickets', [App\Http\Controllers\SupportController::class, 'myTickets'])->name('support.my-tickets');
    Route::get('/ticket/{ticket}', [App\Http\Controllers\SupportController::class, 'showTicket'])->name('support.ticket.show');
    Route::post('/ticket/{ticket}/reply', [App\Http\Controllers\SupportController::class, 'replyToTicket'])->name('support.ticket.reply');

    // مسارات المحفظة
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
    Route::post('/wallet/charge', [WalletController::class, 'charge'])->name('wallet.charge');
    
    // مسارات الإعلانات المحلية
    Route::resource('local-ads', App\Http\Controllers\LocalAdController::class);
});

// مسارات المشرف - إدارة النشرة البريدية
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/newsletters', [App\Http\Controllers\NewsletterController::class, 'index'])->name('admin.newsletters.index');
    Route::delete('/admin/newsletters/{id}', [App\Http\Controllers\NewsletterController::class, 'destroy'])->name('admin.newsletters.destroy');
});

// مسارات لوحة تحكم الأدمن
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // لوحة التحكم الرئيسية
    Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('index');
    
    // إدارة الحملات التطوعية
    Route::get('/campaigns', [App\Http\Controllers\AdminController::class, 'campaigns'])->name('campaigns');
    Route::get('/campaigns/{id}/edit', [App\Http\Controllers\AdminController::class, 'editCampaign'])->name('campaigns.edit');
    Route::put('/campaigns/{id}', [App\Http\Controllers\AdminController::class, 'updateCampaign'])->name('campaigns.update');
    Route::delete('/campaigns/{id}', [App\Http\Controllers\AdminController::class, 'deleteAd'])->name('campaigns.delete');
    
    // إدارة المستخدمين
    Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::get('/users/{id}/edit', [App\Http\Controllers\AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [App\Http\Controllers\AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('users.delete');
    
    // إدارة المنظمات
    Route::get('/organizations', [App\Http\Controllers\AdminController::class, 'organizations'])->name('organizations');
    Route::post('/organizations/{id}/verify', [App\Http\Controllers\AdminController::class, 'verifyOrganization'])->name('organizations.verify');
    
    // إدارة الإعلانات المحلية
    Route::get('/local-ads', [App\Http\Controllers\AdminController::class, 'localAds'])->name('local-ads');
    Route::get('/local-ads/{id}/edit', [App\Http\Controllers\AdminController::class, 'editLocalAd'])->name('local-ads.edit');
    Route::put('/local-ads/{id}', [App\Http\Controllers\AdminController::class, 'updateLocalAd'])->name('local-ads.update');
    Route::post('/local-ads/{id}/approve', [App\Http\Controllers\AdminController::class, 'approveLocalAd'])->name('local-ads.approve');
    Route::post('/local-ads/{id}/reject', [App\Http\Controllers\AdminController::class, 'rejectLocalAd'])->name('local-ads.reject');
    Route::delete('/local-ads/{id}', [App\Http\Controllers\AdminController::class, 'deleteLocalAd'])->name('local-ads.delete');
});

// Diagnostic route for storage issues
Route::get('/storage-diagnostic', function () {
    // Check and create directories if they don't exist
    if (!Storage::disk('public')->exists('profile-photos')) {
        Storage::disk('public')->makeDirectory('profile-photos', 0777);
    }
    
    // Check if the storage link exists
    $storageLink = public_path('storage');
    $storageTarget = storage_path('app/public');
    
    $linkExists = file_exists($storageLink) && is_link($storageLink);
    $linkTarget = $linkExists ? readlink($storageLink) : 'N/A';
    
    // Test file creation
    $testFilePath = 'profile-photos/test-file-' . time() . '.txt';
    $testFileContent = 'This is a test file created at ' . now();
    $fileCreated = Storage::disk('public')->put($testFilePath, $testFileContent);
    
    // Get file URL
    $fileUrl = $fileCreated ? Storage::url($testFilePath) : 'N/A';
    
    // Show diagnostic info
    return response()->json([
        'storage_link_exists' => $linkExists,
        'storage_link_target' => $linkTarget,
        'expected_target' => $storageTarget,
        'link_correct' => $linkTarget === $storageTarget,
        'profile_photos_dir_exists' => Storage::disk('public')->exists('profile-photos'),
        'test_file_created' => $fileCreated,
        'test_file_path' => $testFilePath,
        'test_file_url' => $fileUrl,
        'filesystem_disk' => config('filesystems.default'),
        'public_disk_root' => config('filesystems.disks.public.root'),
        'public_disk_url' => config('filesystems.disks.public.url'),
        'app_url' => config('app.url'),
    ]);
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    // أساسيات لوحة الأدمن
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    
    // إدارة الحملات
    Route::get('/admin/campaigns', [AdminController::class, 'campaigns'])->name('admin.campaigns');
    Route::get('/admin/campaigns/{id}/edit', [AdminController::class, 'editCampaign'])->name('admin.campaigns.edit');
    Route::put('/admin/campaigns/{id}', [AdminController::class, 'updateCampaign'])->name('admin.campaigns.update');
    Route::delete('/admin/campaigns/{id}', [AdminController::class, 'deleteAd'])->name('admin.campaigns.delete');
    
    // إدارة المستخدمين
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    
    // إدارة المنظمات
    Route::get('/admin/organizations', [AdminController::class, 'organizations'])->name('admin.organizations');
    Route::post('/admin/organizations/{id}/verify', [AdminController::class, 'verifyOrganization'])->name('admin.organizations.verify');
    Route::get('/admin/organizations/{id}/edit', [AdminController::class, 'editOrganization'])->name('admin.organizations.edit');
    Route::put('/admin/organizations/{id}', [AdminController::class, 'updateOrganization'])->name('admin.organizations.update');
    Route::delete('/admin/organizations/{id}', [AdminController::class, 'deleteOrganization'])->name('admin.organizations.delete');
    
    // إدارة الإعلانات المحلية
    Route::get('/admin/local-ads', [AdminController::class, 'localAds'])->name('admin.local-ads');
    Route::get('/admin/local-ads/{id}/edit', [AdminController::class, 'editLocalAd'])->name('admin.local-ads.edit');
    Route::put('/admin/local-ads/{id}', [AdminController::class, 'updateLocalAd'])->name('admin.local-ads.update');
    Route::delete('/admin/local-ads/{id}', [AdminController::class, 'deleteLocalAd'])->name('admin.local-ads.delete');
    Route::post('/admin/local-ads/{id}/approve', [AdminController::class, 'approveLocalAd'])->name('admin.local-ads.approve');
    Route::post('/admin/local-ads/{id}/reject', [AdminController::class, 'rejectLocalAd'])->name('admin.local-ads.reject');
    
    // إدارة فرص التطوع
    Route::get('/admin/job-offers', [AdminController::class, 'jobOffers'])->name('admin.job-offers');
    Route::get('/admin/job-offers/{id}/edit', [AdminController::class, 'editJobOffer'])->name('admin.job-offers.edit');
    Route::put('/admin/job-offers/{id}', [AdminController::class, 'updateJobOffer'])->name('admin.job-offers.update');
    Route::delete('/admin/job-offers/{id}', [AdminController::class, 'deleteJobOffer'])->name('admin.job-offers.delete');
    
    // إدارة نشرات الأخبار
    Route::get('/admin/newsletters', [NewsletterController::class, 'index'])->name('admin.newsletters.index');
    Route::delete('/admin/newsletters/{id}', [NewsletterController::class, 'destroy'])->name('admin.newsletters.destroy');
});

require __DIR__.'/auth.php';
