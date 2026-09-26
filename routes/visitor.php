<?php

use App\Http\Controllers\Member\AuthController;
use App\Http\Controllers\Member\CatalogController;
use App\Http\Controllers\Member\EventController;
use App\Http\Controllers\Member\FeedbackController;
use App\Http\Middleware\MemberResponseHeaders;
use Illuminate\Support\Facades\Route;

Route::prefix('visitor/api')->middleware([MemberResponseHeaders::class, 'throttle:member-api'])->group(function () {
    Route::get('auth/csrf', [AuthController::class, 'csrf']);
    Route::post('auth/register', [AuthController::class, 'register'])->middleware('throttle:member-registration');
    Route::post('auth/login', [AuthController::class, 'login'])->middleware('throttle:member-login');
    Route::post('auth/forgot-password', [AuthController::class, 'forgotPassword'])->middleware('throttle:member-recovery');
    Route::post('auth/reset-password', [AuthController::class, 'resetPassword'])->middleware('throttle:member-recovery');
    Route::get('auth/reset-password/{token}', [AuthController::class, 'resetInfo'])->middleware('throttle:member-recovery')->name('visitor.password.reset');

    Route::get('categories', [CatalogController::class, 'categories']);
    Route::get('tags', [CatalogController::class, 'tags']);
    Route::get('explore', [CatalogController::class, 'index']);
    Route::get('upcoming', [CatalogController::class, 'index'])->name('visitor.upcoming');
    Route::get('catalog/{type}/{id}', [CatalogController::class, 'show'])->where('type', 'content|article|character|media|merchandise')->whereNumber('id')->name('visitor.catalog.show');
    Route::get('share/{type}/{id}', [CatalogController::class, 'share'])->where('type', 'content|article|character|media|merchandise')->whereNumber('id');
    Route::get('events', [EventController::class, 'index']);
    Route::get('events/{id}', [EventController::class, 'show'])->whereNumber('id');
    Route::post('feedback', [FeedbackController::class, 'store'])->middleware('throttle:member-feedback');
});
