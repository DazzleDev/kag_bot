<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\AbsenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
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


Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'home']);

	Route::get('/dashboard', function () {
		view('dashboard');
	 })->name('dashboard');

	Route::get('billing', function () {
		return view('billing');
	})->name('billing');

	Route::get('petunjuk', function () {
		return view('petunjuk');
	})->name('petunjuk');

	Route::get('approval', function () {
		return view('approval');
	})->name('approval');

	Route::get('jadwal', function () {
		return view('jadwal');
	})->name('jadwal');

	Route::get('gaji', function () {
		return view('gaji');
	})->name('gaji');

	Route::get('profile', function () {
		return view('profile');
	})->name('profile');

	Route::get('rtl', function () {
		return view('rtl');
	})->name('rtl');

	Route::get('user-management', function () {
		return view('laravel-examples/user-management');
	})->name('user-management');

	Route::get('formperijinan', function () {
		return view('formperijinan');
	})->name('formperijinan');

	Route::get('formdp', function () {
		return view('formdp');
	})->name('formdp');

	Route::get('formcuti', function () {
		return view('formcuti');
	})->name('formcuti');

	Route::get('formsakit', function () {
		return view('formsakit');
	})->name('formsakit');

	Route::get('formcs', function () {
		return view('formcs');
	})->name('formcs');

	Route::get('formss', function () {
		return view('formss');
	})->name('formss');

	Route::get('formlembur', function () {
		return view('formlembur');
	})->name('formlembur');

	Route::get('formske', function () {
		return view('formske');
	})->name('formske');

	Route::get('tables', function () {
		return view('tables');
	})->name('tables');

	Route::get('status', function () {
		return view('status');
	})->name('status');

    Route::get('virtual-reality', function () {
		return view('virtual-reality');
	})->name('virtual-reality');

    Route::get('static-sign-in', function () {
		return view('static-sign-in');
	})->name('sign-in');

    Route::get('static-sign-up', function () {
		return view('static-sign-up');
	})->name('sign-up');

    Route::get('/logout', [SessionsController::class, 'destroy']);
	Route::get('/user-profile', [InfoUserController::class, 'create']);
	Route::post('/user-profile', [InfoUserController::class, 'store']);
    Route::get('/login', function () {
		return view('dashboard');
	})->name('sign-up');
	
});



Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/session', [SessionsController::class, 'store']);
	Route::get('/login/forgot-password', [ResetController::class, 'create']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');

});

Route::get('/login', function () {
    return view('session/login-session');
})->name('login');