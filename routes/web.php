<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

use App\Http\Controllers\ItemController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =========================
// top
// =========================
Route::get('/', function () {
    return view('welcome');
});

// =========================
// auth dummy routes（開発用）
// =========================
Route::get('/login', function () {
    return 'login';
})->name('login');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::get('/dev-login', function () {

    $user = User::first();

    if (! $user) {
        $user = User::create([
            'name'     => 'test',
            'email'    => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
    }

    Auth::login($user);

    return redirect()->route('items.index');
});

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
    // purchase（購入機能一式）
    // =========================

//別の人で購入
    Route::get('/dev-login-buyer', function () {
    Auth::login(\App\Models\User::where('email', 'buyer@example.com')->first());
    return redirect()->route('items.index');
});


    // ① 支払い選択画面
    Route::get('/purchase/{item}/input', [PurchaseController::class, 'input'])
        ->name('purchase.input');

    // ② 入力内容確認画面
    Route::post('/purchase/{item}/confirm', [PurchaseController::class, 'confirm'])
        ->name('purchase.confirm');

    // ③ 購入確定
    Route::post('/items/{item}/purchase', [PurchaseController::class, 'store'])
        ->name('item.purchase');

    // ④ 完了画面
    Route::get('/purchase/{item}/complete', function (\App\Models\Item $item) {
        return view('purchase.complete', compact('item'));
    })->name('purchase.complete');


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
    // address（配送先住所変更）
    // =========================
    Route::get('/address/edit', [AddressController::class, 'edit'])
        ->name('address.edit');

    Route::put('/address', [AddressController::class, 'update'])
        ->name('address.update');

});

require __DIR__ . '/auth.php';

Auth::routes();



