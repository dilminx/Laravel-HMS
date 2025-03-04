<?php

use Faker\Guesser\Name;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LabController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/register', function () {
    return view('Auth.register');
});
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::get('/login', function () {
    return view('Auth.login');})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/logout',[AuthController::class,'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/admin/users',[AdminController::class,'adminAddUser'])->name('admin.addUser');
    Route::get('/admin/users/status/{id}', [AdminController::class, 'toggleStatus'])->name('admin.toggleStatus');

});

Route::middleware(['auth', 'role:doctor'])->group(function () {
    Route::get('/doctor/dashboard', [DoctorController::class, 'index'])->name('doctor.dashboard');
});

Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/patient/dashboard', [PatientController::class, 'index'])->name('patient.dashboard');
});

Route::middleware(['auth', 'role:lab_assistant'])->group(function () {
    Route::get('/lab/dashboard', [LabController::class, 'index'])->name('lab.dashboard');
});