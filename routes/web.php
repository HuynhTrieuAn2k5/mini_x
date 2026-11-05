<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\BlockMuteController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

// Trang chủ hiển thị danh sách Tweets
Route::get('/', [TweetController::class, 'index'])->name('tweets.index');

// Gửi bài viết mới
Route::post('/tweets', [TweetController::class, 'store'])->name('tweets.store');

// Xóa bài viết theo ID
Route::delete('/tweets/{id}', [TweetController::class, 'destroy'])->name('tweets.destroy');

// Các route profile và xác thực của Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/recipients', [MessageController::class, 'recipients'])->name('messages.recipients');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');

    Route::post('/users/{user}/follow', [FollowController::class, 'toggle'])->name('users.follow');
    Route::post('/users/{user}/block', [BlockMuteController::class, 'toggleBlock'])->name('users.block');
    Route::post('/users/{user}/mute', [BlockMuteController::class, 'toggleMute'])->name('users.mute');

    Route::post('/profile/update', [UserProfileController::class, 'update'])->name('profile.custom_update');
});

Route::get('/{username}/followers', [FollowController::class, 'followers'])->name('users.followers');
Route::get('/{username}/following', [FollowController::class, 'following'])->name('users.following');

require __DIR__.'/auth.php';