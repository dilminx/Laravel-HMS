<?php
namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MedicalHistory;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Feedback;
use Carbon\Carbon;
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
                'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            ]);

            // Find and update the current user's details
            $user = User::find(Auth::id());
            if (!$user) {
                return redirect()->route('doctor.dashboard')->with('error', 'User not found.');
            }

            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            if ($request->hasFile('profile_photo')) {
                // Delete old profile picture if exists
                if ($user->profile_photo && file_exists(storage_path('app/public/profile_pictures/' . $user->profile_photo))) {
                    unlink(storage_path('app/public/profile_pictures/' . $user->profile_photo));
                }
    
                // Upload new profile photo
                $file = $request->file('profile_photo');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/profile_pictures', $filename);
                $user->profile_photo = $filename;
            }
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
        //delete available_date table past date. userta parana date pennanne natha
        DoctorAvailability::where('available_date', '<', Carbon::today())->delete();
        $doctor = Doctor::where('users_id', Auth::id())->first();

        if (!$doctor) {
            return redirect()->route('doctor.dashboard')->with('error', 'Doctor profile not found!');
        }

        // Use correct doctor_id
        $availabilities = DoctorAvailability::where('doctor_id', $doctor->users_id)->get();

        return view('doctor.available_dates', compact('doctor', 'availabilities'));
    }


    // Add availability for the doctor
    public function addAvailability(Request $request)
    {
        // dd( $request->available_date);
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
                'doctor_id' => $doctor->users_id,
                'available_date' => $request->available_date,
            ]);


            return redirect()->route('doctor.available_dates')->with('success', 'Availability added successfully!');

        } catch (\Throwable $th) {

            return redirect()->route('doctor.available_dates')->with('error', 'Error added Date!' . $th->getMessage());

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

        if ($availability->doctor_id == $doctor->users_id) {
            $availability->delete();
            return redirect()->route('doctor.available_dates')->with('success', 'Availability date deleted successfully!');
        }

        return redirect()->route('doctor.available_dates')->with('error', 'You do not have permission to delete this availability.');
    }
    // ======================================Appointment Doctor==================================
    public function doctorAppointments()
    {
        $doctorId = auth()->id(); // Get the logged-in doctor's ID
    
        // Fetch only confirmed appointments for this doctor, ordered by date
        $appointments = Appointment::where('doctor_id', $doctorId)
                        ->where('status', 'confirmed')
                        ->orderBy('appointment_date', 'asc')
                        ->get();
    
        // Group the appointments by appointment date
        $appointmentsByDate = $appointments->groupBy('appointment_date');
    
        return view('doctor.appointments', compact('appointmentsByDate'));
    }
    public function patientsList()
    {
        $patients = User::where('role','patient')->with('patient')->get();
        return view('doctor.patients_list', compact('patients')); 

    }
    // =====================doctor view patient profile ==================
    public function patientProfile($id){
        $patientDetails = User::where('id', $id)->first();
        $medicalHistory = MedicalHistory::where('patient_id', $id)->get();
        return view('doctor.patient_view',compact('patientDetails','medicalHistory'));
    }
    public function addMedicalNote(Request $request) {
        // Validate the input
        $request->validate([
            'diagnosis' => 'required|string|max:255',
            'treatment' => 'required|string|max:255',
            'patient_id' => 'required|exists:users,id', // Ensure patient exists
            'doctor_id' => 'required|exists:users,id'   // Ensure doctor exists
        ]);
    
        // Store the medical history in the database
        MedicalHistory::create([
            'diagnosis' => $request->diagnosis,
            'treatment' => $request->treatment,
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
        ]);
    
        // Redirect back with success message
        return back()->with('success', 'Medical note added successfully!');
    }
    public function payments($id){
        $paymentDetails = Payment::where('doctor_id',$id)->get();
        return view('doctor.payments',compact('paymentDetails'));
    }
    




}
