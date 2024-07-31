<?php

use App\Domains\User\Models\User;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MicrositeController;
use App\Http\Controllers\PaymentRecordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        $user = User::with('roles')->find($user->id);
        return Inertia::render('Dashboard', [
            'auth' => [
                'user' => $user,
            ],
        ]);
    })->name('dashboard');

    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::resource('category', CategoryController::class);
    });

    Route::resource('microsite', MicrositeController::class);

    Route::prefix('microsite/{microsite}')->group(function () {
        Route::get('payment_records', [PaymentRecordController::class, 'index'])->name('microsite.payment_records.index');
        Route::get('payment_records/create', [PaymentRecordController::class, 'create'])->name('microsite.payment_records.create');
        Route::post('payment_records', [PaymentRecordController::class, 'store'])->name('microsite.payment_records.store');
        Route::get('payment_records/{payment_record}', [PaymentRecordController::class, 'show'])->name('microsite.payment_records.show');
        Route::get('payment_records/{payment_record}/edit', [PaymentRecordController::class, 'edit'])->name('microsite.payment_records.edit');
        Route::put('payment_records/{payment_record}', [PaymentRecordController::class, 'update'])->name('microsite.payment_records.update');
        Route::delete('payment_records/{payment_record}', [PaymentRecordController::class, 'destroy'])->name('microsite.payment_records.destroy');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
});

require __DIR__ . '/auth.php';
