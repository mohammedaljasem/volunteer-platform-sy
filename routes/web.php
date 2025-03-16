<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\ParticipationRequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // مسارات الحملات التطوعية
    Route::get('/ads', [AdController::class, 'index'])->name('ads.index');
    Route::get('/ads/create', [AdController::class, 'create'])->middleware('can:create-campaign')->name('ads.create');
    Route::post('/ads', [AdController::class, 'store'])->middleware('can:create-campaign')->name('ads.store');
    Route::get('/ads/{ad}', [AdController::class, 'show'])->name('ads.show');
    Route::get('/ads/{ad}/edit', [AdController::class, 'edit'])->middleware('can:edit-campaign')->name('ads.edit');
    Route::put('/ads/{ad}', [AdController::class, 'update'])->middleware('can:edit-campaign')->name('ads.update');
    Route::delete('/ads/{ad}', [AdController::class, 'destroy'])->middleware('can:delete-campaign')->name('ads.destroy');
    
    // مسارات التبرع للحملات
    Route::get('/ads/{ad}/donate', [AdController::class, 'showDonateForm'])->middleware('can:donate-to-campaign')->name('ads.donate');
    Route::post('/ads/{ad}/donate', [AdController::class, 'donate'])->middleware('can:donate-to-campaign')->name('ads.donate.store');
    
    // مسارات التعليق على الحملات
    Route::post('/ads/{ad}/comment', [AdController::class, 'comment'])->middleware('can:comment-on-campaign')->name('ads.comment');

    // مسارات فرص التطوع
    Route::resource('job-offers', JobOfferController::class);
    Route::post('/job-offers/{jobOffer}/request', [JobOfferController::class, 'requestParticipation'])
        ->middleware('can:request-participation')
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
});

require __DIR__.'/auth.php';
