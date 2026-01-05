<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ItemController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\LikeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =========================
// top
// =========================
Route::get('/', [ItemController::class, 'index']);


// =========================
// auth required routes
// =========================
Route::middleware(['auth'])->group(function () {

    // =========================
    // items
    // =========================
    Route::get('/items', [ItemController::class, 'index'])
        ->name('items.index');

    Route::get('/items/create', [ItemController::class, 'create'])
        ->name('items.create');

    Route::post('/items', [ItemController::class, 'store'])
        ->name('items.store');

    Route::get('/items/{item}', [ItemController::class, 'show'])
        ->name('items.show');

    Route::delete('/items/{item}', [ItemController::class, 'destroy'])
        ->name('items.destroy');


    // =========================
    // comments
    // =========================
    Route::post('/items/{item}/comments', [CommentController::class, 'store'])
        ->name('comments.store');


    // =========================
    // purchase（購入機能）
    // =========================

    // 開発用：購入者ログイン
    Route::get('/dev-login-buyer', function () {
        Auth::login(
            \App\Models\User::where('email', 'buyer@example.com')->first()
        );
        return redirect()->route('items.index');
    });

    // ① 購入画面
    Route::get('/purchase/{item}/input', [PurchaseController::class, 'input'])
        ->name('purchase.input');

    // ② 購入確定（Stripe Checkout）
    Route::post('/items/{item}/purchase', [PurchaseController::class, 'store'])
        ->name('item.purchase');

    // ③ 購入完了
    Route::get('/purchase/{item}/complete', [PurchaseController::class, 'complete'])
        ->name('purchase.complete');


    // =========================
    // mypage
    // =========================
    Route::get('/mypage', [MypageController::class, 'index'])
        ->name('mypage.index');


    // =========================
    // profile
    // =========================
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');


    // =========================
    // address
    // =========================
    Route::get('/address/edit', [AddressController::class, 'edit'])
        ->name('address.edit');

    Route::put('/address', [AddressController::class, 'update'])
        ->name('address.update');


    // =========================
    // dashboard
    // =========================
    Route::get('/dashboard', function () {
        return redirect()->route('items.index');
    })->name('dashboard');
});


// =========================
// like（いいね機能）
// =========================
Route::middleware(['auth'])->group(function () {

    Route::post('/items/{item}/like', [LikeController::class, 'store'])
        ->name('likes.store');

    Route::delete('/items/{item}/like', [LikeController::class, 'destroy'])
        ->name('likes.destroy');

    Route::get('/mypage/likes', [LikeController::class, 'index'])
        ->name('likes.index');
});


require __DIR__ . '/auth.php';





