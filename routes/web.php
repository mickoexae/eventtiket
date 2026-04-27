<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\VenueController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\TiketController; 
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController; 
use App\Http\Controllers\Admin\UserController as AdminUserController; 
use App\Http\Controllers\UserController as PelangganController;
use App\Http\Controllers\OrderController; 
use App\Http\Controllers\LandingPageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Models\Order;
use App\Models\User;
use App\Models\Voucher;

// --- Public Routes ---
Route::get('/', [LandingPageController::class, 'index'])->name('landing');

// --- Dashboard Logic ---
Route::get('/dashboard', function () {
    $user = Auth::user();
    $data = [
        'totalPemasukan' => 0,
        'keuntungan' => 0,
        'totalUser' => 0,
        'totalOrder' => 0,
        'vouchers' => collect(),
    ];

    if ($user->role == 'admin') {
        $data['totalPemasukan'] = Order::where('status', 'paid')->sum('total'); 
        $data['keuntungan'] = $data['totalPemasukan'] * 0.1; 
        $data['totalUser'] = User::where('role', 'user')->count();
        $data['totalOrder'] = Order::count();
    } elseif ($user->role == 'user') {
        $data['vouchers'] = Voucher::latest()->get(); 
    }

    return view('dashboard', $data);
})->middleware(['auth', 'verified'])->name('dashboard');

// --- Authenticated Routes ---
Route::middleware('auth')->group(function () {
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Pelanggan / User Features
    Route::get('/cari-tiket', [PelangganController::class, 'cariTiket'])->name('user.cari_tiket');
    Route::get('/cari-tiket/{id}', [PelangganController::class, 'showEvent'])->name('user.event.detail');
    Route::get('/checkout/{id_tiket}', [PelangganController::class, 'checkout'])->name('user.checkout');
    Route::post('/checkout-multiple', [EventController::class, 'checkoutMultiple'])->name('user.checkout_multiple');
    
    // Order Flow (ALUR BARU)
    // 1. Simpan order dengan status 'pending'
    Route::post('/order/store', [OrderController::class, 'store'])->name('user.proses_bayar');
    
    // 2. Lihat detail order (untuk munculkan tombol bayar)
    Route::get('/order/detail/{id_order}', [OrderController::class, 'show'])->name('user.order.detail');
    
    // 3. Eksekusi tombol bayar (mengubah 'pending' ke 'paid')
    Route::post('/order/bayar/{id}', [OrderController::class, 'bayar'])->name('user.order.bayar');

    // Post-Payment Features
    Route::get('/tiket-saya', [PelangganController::class, 'tiketSaya'])->name('user.tiket_saya');
    Route::get('/e-tiket/{qr_code}', [OrderController::class, 'showEtiket'])->name('user.etiket.show');
    Route::post('/cek-voucher', [PelangganController::class, 'cekVoucher'])->name('user.cek_voucher');

    // --- Admin & Petugas Routes ---
    Route::prefix('admin')->name('admin.')->group(function () {
        
        Route::middleware(['role:admin,petugas'])->group(function () {
            Route::get('/scanner', [AdminOrderController::class, 'scanner'])->name('scanner');
            Route::post('/scanner/prosess', [AdminOrderController::class, 'cekTiket'])->name('scanner.prosess');
            Route::get('/laporan-kehadiran', [AdminOrderController::class, 'laporanKehadiran'])->name('laporan.kehadiran');
        });

        Route::middleware(['role:admin'])->group(function () {
            Route::patch('/user/{id_user}/toggle', [AdminUserController::class, 'toggleStatus'])->name('user.toggle');
            Route::resource('user', AdminUserController::class)->parameters(['user' => 'id_user']);
            
            Route::get('/venue/trash', [VenueController::class, 'trash'])->name('venue.trash');
            Route::post('/venue/{id}/restore', [VenueController::class, 'restore'])->name('venue.restore');
            Route::delete('/venue/{id}/force-delete', [VenueController::class, 'forceDelete'])->name('venue.force-delete');

            Route::get('/event/trash', [EventController::class, 'trash'])->name('event.trash');
            Route::post('/event/{id}/restore', [EventController::class, 'restore'])->name('event.restore');
            Route::delete('/event/{id}/force-delete', [EventController::class, 'forceDelete'])->name('event.force-delete');

            Route::get('/tiket/trash', [TiketController::class, 'trash'])->name('tiket.trash');
            Route::post('/tiket/{id}/restore', [TiketController::class, 'restore'])->name('tiket.restore');
            Route::delete('/tiket/{id}/force-delete', [TiketController::class, 'forceDelete'])->name('tiket.force-delete');

            Route::resource('tiket', TiketController::class);
            Route::resource('event', EventController::class);
            Route::resource('venue', VenueController::class);
            Route::resource('voucher', VoucherController::class);
            Route::resource('petugas', PetugasController::class)->parameters(['petugas' => 'petugas']);
            
            Route::resource('order', AdminOrderController::class)->parameters(['order' => 'id_order']);
            Route::get('/laporan-keuangan', [AdminOrderController::class, 'laporan'])->name('laporan');
        });
    });
});

require __DIR__.'/auth.php';