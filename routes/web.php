<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use League\OAuth1\Client\Server\User;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CreateCarClass;
use App\Http\Controllers\UserController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/feature', function () {
    return view('feature');
})->name('feature');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('login/github', [App\Http\Controllers\Auth\LoginController::class, 'redirectToGithub'])->name('login.github');
Route::get('login/github/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleGithubCallback']);



Route::middleware('auth', 'verified')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/rental', [RentalController::class, 'index'])->name('rental.index');
    Route::post('/rental', [RentalController::class, 'store'])->name('rental.store');
    Route::patch('/rental/{rental}', [RentalController::class, 'update'])->name('rental.update');
    Route::patch('/rental/{rental}/complete', [RentalController::class, 'complete'])->name('rental.complete');
    Route::patch('/rental/{rental}/uncomplete', [RentalController::class, 'uncomplete'])->name('rental.uncomplete');
    Route::delete('/rental/{rental}', [RentalController::class, 'destroy'])->name('rental.destroy');
    Route::delete('/rental', [RentalController::class, 'destroyCompleted'])->name('rental.deleteallcompleted');

    Route::get('/car', [CarController::class, 'index'])->name('car.index');
    // Route::get('/car/create', [CarController::class, 'create'])->name('car.create');
    Route::get('/car/create', CreateCarClass::class)->name('car.create');
    Route::post('/car', [CarController::class, 'store'])->name('car.store');
    Route::get('/car/{car}/edit', [CarController::class, 'edit'])->name('car.edit');
    Route::patch('/car/{car}', [CarController::class, 'update'])->name('car.update');
    Route::delete('/car/{car}', [CarController::class, 'destroy'])->name('car.destroy');

    Route::get('/booking', function () {
        return view('booking');
    })->name('booking.index');


    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
});

require __DIR__ . '/auth.php';
