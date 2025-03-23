<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Payment;
use App\Models\User;
use App\Models\Doctor;

use Illuminate\Http\Request;
use App\Models\DoctorCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('admin.dashboard', compact('user'));
    }

    public function users()
    {
        $users = User::where('role', '!=', 'admin')->get();


        return view('admin.users', compact('users'));
    }

    public function adminAddUser(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:5',
                'role' => 'required',

            ]);
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'status' => 'active',
            ]);
            if ($user->role === 'doctor') {
                $category = DoctorCategory::find($request->specialization);

                Doctor::create([
                    'specialization' => $category->name,
                    'phone' => $request->phone,
                    'work_hospital' => $request->work_hospital,
                    'users_id' => $user->id,
                    'doctor_category_id' => $request->specialization,
                ]);
            }

            return redirect()->route('admin.users')->with('success', 'User Add Successfully');

        } catch (\Exception $e) {
            // Return generic error message if something goes wrong
            return redirect()->route('admin.users')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = ($user->status === 'active') ? 'inactive' : 'active';
        $user->save();

        return redirect()->route('admin.users')->with('success', 'User status updated successfully.');
    }

    public function appointmentDetails()
    {
        $appointmentDetails = Appointment::all();
        return view('admin.appointment', compact('appointmentDetails'));

    }
    public function confirmAppointment($id)
{
    $appointment = Appointment::findOrFail($id);
    $appointment->status = 'confirmed';
    $appointment->save();

    // Fetch the first payment related to the appointment
    $payment = Payment::where('appointment_id', $id)->first();
    
    // Debugging: Check if payment exists
    if (!$payment) {
        return back()->with('error', 'No payment found for this appointment.');
    }

    $payment->status = 'completed';
    $payment->save();

    return back()->with('success', 'Appointment confirmed successfully.');
}


    // Cancel Appointment
    public function cancelAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'cancelled';
        $appointment->save();

        $paymentStatus = Payment::where('appointment_id', $id)->first();
     
        $paymentStatus->status = 'cancelled';
        $paymentStatus->save();

        return back()->with('success', 'Appointment canceled successfully.');
    }
}
