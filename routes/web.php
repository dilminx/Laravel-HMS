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
    return view('Auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/admin/users', [AdminController::class, 'adminAddUser'])->name('admin.addUser');
    Route::get('/admin/users/status/{id}', [AdminController::class, 'toggleStatus'])->name('admin.toggleStatus');
    Route::get('/admin/appointments', [AdminController::class, 'appointmentDetails'])->name('admin.appointments');
    Route::put('/admin/appointments/{id}/confirm', [AdminController::class, 'confirmAppointment'])->name('admin.appointments.confirm');
Route::delete('/admin/appointments/{id}/cancel', [AdminController::class, 'cancelAppointment'])->name('admin.appointments.cancel');
});

Route::middleware(['auth', 'role:doctor'])->group(function () {

    Route::get('/doctor/dashboard', [DoctorController::class, 'index'])->name('doctor.dashboard');
    Route::post('doctor/update', [DoctorController::class, 'updateDoctor'])->name('doctor.update');
    Route::post('/feedback/submit', [DoctorController::class, 'feedbackStore'])->name('feedback.submit');
    Route::get('/doctor/available_dates', [DoctorController::class, 'availableDates'])->name('doctor.available_dates');
    Route::post('/doctor/availability', [DoctorController::class, 'addAvailability'])->name('doctor.addAvailability');
    Route::delete('/doctor/availability/{id}', [DoctorController::class, 'deleteAvailability'])->name('doctor.deleteAvailability');

    Route::get('/doctor/appointments', [DoctorController::class, 'doctorAppointments'])->name('doctor.appointments');


    Route::get('/doctor/patients_list', [DoctorController::class, 'patientsList'])->name('doctor.patients_list');
    Route::get('/doctor/patient_view/{id}', [DoctorController::class, 'patientProfile'])->name('doctor.patientProfile');
    Route::post('/doctor/patient_view/addmedical', [DoctorController::class, 'addMedicalNote'])->name('doctor.addMedical');


    Route::get('/doctor/payments/{id}', [DoctorController::class, 'payments'])->name('doctor.payments');


});

Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/patient/dashboard', [PatientController::class, 'index'])->name('patient.dashboard');
    Route::post('/patient/update', [PatientController::class, 'patientUpdate'])->name('patient.update');
    Route::get('/patient/medical_history', [PatientController::class, 'medicalHistoryView'])->name('patient.history');
    Route::get('/patient/appointments', [PatientController::class, 'doctorList'])->name('patient.appointments');
    Route::get('/patient/booking', [PatientController::class, 'bookingDoctors'])->name('patient.booking');
    Route::get('/patient/doctor_view/{doctor}', [PatientController::class, 'showDoctor'])->name('patient.doctor.view');
    Route::post('/patient/book-appointment', [PatientController::class, 'bookAppointment'])->name('patient.book.appointment');
    Route::post('/patient/submit-feedback', [PatientController::class, 'feedbackSubmit'])->name('patient.submit.feedback');
    Route::delete('/patient/appointment-cancel/{id}', [PatientController::class, 'appointmentCancel'])->name('appointment.cancel');

    Route::get('/patient/payment', [PatientController::class, 'paymentHistory'])->name('patient.payments');

});


Route::middleware(['auth', 'role:lab_assistant'])->group(function () {
    Route::get('/lab/dashboard', [LabController::class, 'index'])->name('lab.dashboard');
});