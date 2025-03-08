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
    Route::post('doctor/update', [DoctorController::class, 'updateDoctor'])->name('doctor.update');
    Route::post('/feedback/submit', [DoctorController::class, 'feedbackStore'])->name('feedback.submit');
    Route::get('/doctor/available_dates', [DoctorController::class, 'availableDates'])->name('doctor.available_dates');
    Route::post('/doctor/availability', [DoctorController::class, 'addAvailability'])->name('doctor.addAvailability');
    Route::delete('/doctor/availability/{id}', [DoctorController::class, 'deleteAvailability'])->name('doctor.deleteAvailability');
 
    Route::get('/doctor/appointments', [DoctorController::class, 'appointments'])->name('doctor.appointments');
    
    
    Route::get('/doctor/patients_list', [DoctorController::class, 'patientsList'])->name('doctor.patients_list');
    
    
    Route::get('/doctor/payments', [DoctorController::class, 'payments'])->name('doctor.payments');
    
    
  
    
}); 

Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/patient/dashboard', [PatientController::class, 'index'])->name('patient.dashboard');
    Route::post('/patient/update', [PatientController::class, 'patientUpdate'])->name('patient.update');
    Route::get('/patient/history', [PatientController::class, 'history'])->name('patient.history');
    Route::get('/patient/doctors', [PatientController::class, 'doctorList'])->name('patient.doctors');
    Route::get('/patient/booking', [PatientController::class, 'bookingDoc'])->name('patient.bookings');
    Route::get('/patient/payment', [PatientController::class, 'payment'])->name('patient.payments');

});

Route::middleware(['auth', 'role:lab_assistant'])->group(function () {
    Route::get('/lab/dashboard', [LabController::class, 'index'])->name('lab.dashboard');
});