<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Models\DoctorAvailability;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    // Show the doctor dashboard
    public function index()
    {
        $doctor = Doctor::where('users_id', Auth::id())->first(); // Get the doctor data

        if (!$doctor) {
            return redirect()->back()->with('error', 'Doctor profile not found.');
        }

        // Fetch feedbacks for this doctor
        $feedbacks = Feedback::where('doctor_id', Auth::id())->get();


        return view('doctor.dashboard', compact('doctor', 'feedbacks'));
    }


    // Update doctor information
    public function updateDoctor(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users,email,' . Auth::id(),
                'phone' => 'required',
                'specialization' => 'required',
                'work_hospital' => 'required',
            ]);

            // Find and update the current user's details
            $user = User::find(Auth::id());
            if (!$user) {
                return redirect()->route('doctor.dashboard')->with('error', 'User not found.');
            }

            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->save();

            // Find and update the associated doctor record
            $doctor = Doctor::where('users_id', Auth::id())->first();
            if ($doctor) {
                $doctor->phone = $request->phone;
                $doctor->specialization = $request->specialization;
                $doctor->work_hospital = $request->work_hospital;
                $doctor->save();
            }

            return redirect()->route('doctor.dashboard')->with('success', 'Doctor updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('doctor.dashboard')->with('error', 'An error occurred: ' . $e->getMessage());
        }

    }
    

    // ========================Second Page============================

    public function availableDates()
    {
        $doctor = Doctor::where('users_id', Auth::id())->first();

        if (!$doctor) {
            return redirect()->route('doctor.dashboard')->with('error', 'Doctor profile not found!');
        }

        // Use correct doctor_id
        $availabilities = DoctorAvailability::where('doctor_id', $doctor->id)->get();

        return view('doctor.available_dates', compact('doctor', 'availabilities'));
    }


    // Add availability for the doctor
    public function addAvailability(Request $request)
    {
        try {
            $request->validate([
                'available_date' => 'required|date|unique:doctor_availability,available_date,NULL,id,doctor_id,' . Auth::id(),
            ]);
    
            // Get the correct doctor_id from the 'doctors' table
            $doctor = Doctor::where('users_id', Auth::id())->first();
    
            if (!$doctor) {
                return redirect()->route('doctor.available_dates')->with('error', 'Doctor profile not found!');
            }
    
    
            // Save correct doctor_id
            DoctorAvailability::create([
                'doctor_id' => $doctor->id, 
                'available_date' => $request->available_date,
            ]);
    
    
            return redirect()->route('doctor.available_dates')->with('success', 'Availability added successfully!');
        
        } catch (\Throwable $th) {

            return redirect()->route('doctor.available_dates')->with('error', 'Error added Date!');

        }
        
    }


    // Delete an availability date
    public function deleteAvailability($id)
    {
        $availability = DoctorAvailability::findOrFail($id);
        $doctor = Doctor::where('users_id', Auth::id())->first();

        if (!$doctor) {
            return redirect()->route('doctor.available_dates')->with('error', 'Doctor profile not found!');
        }

        if ($availability->doctor_id == $doctor->id) { 
            $availability->delete();
            return redirect()->route('doctor.available_dates')->with('success', 'Availability date deleted successfully!');
        }

        return redirect()->route('doctor.available_dates')->with('error', 'You do not have permission to delete this availability.');
    }


}
