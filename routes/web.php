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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [WelcomeController::class, 'index']);

// مسارات متاحة للجميع
Route::get('/map', [MapController::class, 'index'])->name('map');
Route::get('/api/locations', [MapController::class, 'getLocations'])->name('api.locations');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/debug', [ProfileController::class, 'debug'])->name('profile.debug');
    
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
});

// مسارات المشرف - إدارة النشرة البريدية
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/newsletters', [App\Http\Controllers\NewsletterController::class, 'index'])->name('admin.newsletters.index');
    Route::delete('/admin/newsletters/{id}', [App\Http\Controllers\NewsletterController::class, 'destroy'])->name('admin.newsletters.destroy');
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

require __DIR__.'/auth.php';
