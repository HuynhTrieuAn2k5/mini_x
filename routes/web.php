<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TweetController;
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
});

require __DIR__.'/auth.php';