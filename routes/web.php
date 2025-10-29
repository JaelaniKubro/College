<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\OrderController;
use App\Models\MenuItem;
use App\Models\Order;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Routes Utama
|--------------------------------------------------------------------------
*/

Route::get('/', [SellerController::class, 'welcome'])->name('home');

Route::get('/logout', function () {
    session()->flush(); // Hapus semua data session
    return redirect()->route('home')->with('success', 'Anda berhasil logout.');
})->name('logout');


// Auth
Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup.post');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Route order
Route::post('/buyer/order/{id}', [OrderController::class, 'store'])->name('buyer.order');

Route::middleware(['web'])->group(function () {

    // Seller Dashboard
    Route::get('/dashboard/seller', [SellerController::class, 'dashboard'])->name('dashboard.seller');

    // Buyer Dashboard (tampilkan semua menu & riwayat pesanan)
    Route::get('/dashboard/buyer', function (Request $request) {
        if (!session('user_id') || session('role') !== 'buyer') {
            return redirect()->route('login')->with('error', 'Anda harus login sebagai pembeli.');
        }

        $menus = MenuItem::latest()->get();
        $orders = Order::where('buyer_id', session('user_id'))->with('menu')->latest()->get();

        return view('dashboard_buyer', compact('menus', 'orders'));
    })->name('dashboard.buyer');

    // Klik detail menu → arahkan ke dashboard_buyer juga, tapi kirim data $menu
    Route::get('/menu/{id}', function ($id) {
        $menu = MenuItem::findOrFail($id);
        return view('dashboard_buyer', compact('menu'));
    })->name('buyer.menu.detail');

    // Upload dan Kelola Menu Seller
    Route::get('/seller/upload-menu', [SellerController::class, 'showUploadForm'])->name('dashboard.upload.menu');
    Route::post('/seller/upload-menu', [SellerController::class, 'storeMenu'])->name('seller.store.menu');
    Route::get('/seller/edit-menu/{id}', [SellerController::class, 'editMenu'])->name('seller.edit.menu');
    Route::put('/seller/update-menu/{id}', [SellerController::class, 'updateMenu'])->name('seller.update.menu');
    Route::delete('/seller/delete-menu/{id}', [SellerController::class, 'deleteMenu'])->name('seller.delete.menu');

    // Form Rincian Pesanan
    Route::get('/buyer/order-form/{id}', function ($id) {
        $menu = \App\Models\MenuItem::findOrFail($id);
        return view('buyer_order_form', compact('menu'));
    })->name('buyer.order.form');

    // Aksi seller terhadap pesanan
    Route::put('/seller/order/{id}/complete', [App\Http\Controllers\OrderController::class, 'completeOrder'])->name('seller.order.complete');
    Route::put('/seller/order/{id}/cancel', [App\Http\Controllers\OrderController::class, 'cancelOrder'])->name('seller.order.cancel');


});


