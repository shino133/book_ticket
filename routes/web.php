<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ManagerMovieController;
use App\Http\Controllers\ManagerShowController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserMovieController;
use App\Models\Movie;
use App\Models\Role;
use App\Models\Show;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

//----------------------------------------------------------------------
// Trang chủ và liên hệ
//----------------------------------------------------------------------
Route::get('/', function () {
    $movies = Movie::all()->collect();
    return view('home.home', [
        'top4movies' => $movies->sortByDesc('rating')->take(4),
        'newest_movies' => $movies->sortByDesc('release_date')->take(6),
    ]);
})->name('home');

Route::view('/contact', 'pages.contact-us')->name('contact-us');

//----------------------------------------------------------------------
// Routes dành cho khách (guest)
//----------------------------------------------------------------------
Route::middleware('guest')->group(function () {
    Route::view('login', 'auth.login')->name('login');
    Route::post('login', [SessionController::class, 'store']);

    Route::view('register', 'auth.register', [
        'roles' => Role::whereNot('code', Role::ADMIN_CODE)->get()
    ])->name('register');
    Route::post('register', [UserController::class, 'store']);

    // Leads (chỉ dành cho khách)
    Route::post('leads', [LeadController::class, 'store'])->name('leads');
});

//----------------------------------------------------------------------
// Routes yêu cầu xác thực (auth required)
//----------------------------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::post('logout', [SessionController::class, 'destroy'])->name('logout');

    // Đặt chỗ
    Route::resource('reservations', ReservationController::class);

    // Dashboard người dùng
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
});

//----------------------------------------------------------------------
// Movies & Shows
//----------------------------------------------------------------------
Route::resource('movies', UserMovieController::class)->only(['index', 'show']);

Route::get('json/shows/{show}', fn (Show $show) =>
    [
        ...$show->load('room')->toArray(),
        'reservations' => $show->reservationsSeats()->map(fn ($i) => intval($i)),
    ]
);

//----------------------------------------------------------------------
// Admin Panel
//----------------------------------------------------------------------
Route::prefix('admin')->middleware('can:admin')->name('admin.')->group(function () {
    // Quản lý người dùng
    Route::resource('users', AdminUserController::class);
    Route::get('manager-requests', [AdminUserController::class, 'managerRequests'])->name('manager-requests');

    // Trang dashboard
    Route::get('dashboard', [AdminUserController::class, 'dashboard'])->name('dashboard');
});
//----------------------------------------------------------------------

//----------------------------------------------------------------------
// Manager Panel
//----------------------------------------------------------------------
Route::prefix('manager')->middleware('can:manager')->name('manager.')->group(function () {
    // Quản lý phim
    Route::resource('movies', ManagerMovieController::class);
    Route::get('dashboard', [ManagerMovieController::class, 'dashboard'])->name('dashboard');

    // Quản lý suất chiếu
    Route::resource('shows', ManagerShowController::class);
});
//----------------------------------------------------------------------
