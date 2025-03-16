<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\ProfileController;
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
});

require __DIR__.'/auth.php';
