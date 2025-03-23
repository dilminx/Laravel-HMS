<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\Feedback;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\DoctorCategory;
use App\Models\MedicalHistory;
use App\Models\DoctorAvailability;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use function PHPUnit\Framework\returnValueMap;

class PatientController extends Controller
{
    public function index()
    {
        $patient = Patient::where('users_id', Auth::id())->first();
        return view('patient.dashboard', compact('patient'));
    }
    public function patientUpdate(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'DOB' => 'nullable|date',
                'blood_group' => 'nullable|string|max:10',
                'phone' => 'nullable|string|max:20',
                'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',

            ]);
            $patient = Auth::user(); // Get the logged-in patient

            // Handle Image Upload
            if ($request->hasFile('profile_photo')) {
                // Delete old image if exists
                if ($patient->profile_photo) {
                    Storage::delete('public/profile_photos/' . $patient->profile_photo);
                }

                // Save new image
                $fileName = time() . '.' . $request->profile_photo->extension();
                $request->profile_photo->storeAs('public/profile_photos', $fileName);
                $patient->profile_photo = $fileName;
            }


            $user = Auth::user();
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
            ]);

            $patient = Patient::where('users_id', Auth::id())->first();
            if ($patient) {
                $patient->update([
                    'DOB' => $request->DOB,
                    'blood_group' => $request->blood_group,
                    'phone' => $request->phone,
                ]);
            }

            return redirect()->back()->with('success', 'Profile updated successfully!');

        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Somthing Went Wrong' . $e->getMessage());
        }
    }

    public function medicalHistoryView()
    {
        $medicals = MedicalHistory::where('patient_id', Auth::id())->get();
        return view('patient.medical_history', compact('medicals'));
    }

    public function bookingDoctors(){
        $categories = DoctorCategory::with('doctors.user')->get();
       

        return view('patient.booking', compact('categories'));
  
        
    }

    public function doctorList()
    {
        
        $myappointments = Appointment::where('patient_id', Auth::id())
        ->with('doctor')->get();

        $categories = DoctorCategory::with('doctors.user')->get();
        return view('patient.appointments', compact('categories','myappointments'));
    }
    public function showDoctor($id)
{
    // Fetch doctor availability
    $availabilities = DoctorAvailability::where('doctor_id', $id)->get();
    
    // Fetch feedback related to the doctor
    $feedbacks = Feedback::where('doctor_id', $id)->get();
    
    // Fetch doctor details from `users` table
    $doctorDetails = User::where('id', $id)->first();
    
    // Fetch doctor-specific details from `doctors` table
    $doctorDetails2 = Doctor::where('users_id', $id)->first(); 

    // Pass data to the view
    return view('patient.doctor_view', compact('doctorDetails', 'doctorDetails2', 'availabilities', 'feedbacks'));
}

    
public function bookAppointment(Request $request)
{
    try {
        // Step 1: Validate input
        $request->validate([
            'doctor_id' => 'required',
            'appointment_date' => 'required|date',
            'payment_method' => 'required|in:cash,card',
        ]);

        // Step 2: Check if appointment already exists
        $existingAppointment = Appointment::where('patient_id', auth()->id())
            ->where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->first();

        if ($existingAppointment) {
            return back()->with('error', 'You have already booked an appointment with this doctor on this date.');
        }

        // Step 3: Find doctor availability
        $doctorAvailability = DoctorAvailability::where('doctor_id', $request->doctor_id)
            ->where('available_date', $request->appointment_date)
            ->with('user.doctor.category') 
            ->first();

        if (!$doctorAvailability) {
            return back()->with('error', 'Doctor is not available on this date.');
        }

        if (!$doctorAvailability->user->doctor) {
            return back()->with('error', 'Doctor details not found.');
        }

        if (!$doctorAvailability->user->doctor->category) {
            return back()->with('error', 'Doctor does not have an assigned category.');
        }

        $price = $doctorAvailability->user->doctor->category->price;  // Corrected price retrieval

        // Step 4: Determine appointment status
        $appointmentStatus = ($request->payment_method == 'card') ? 'confirmed' : 'pending';

        // Step 5: Create appointment
        $appointment = Appointment::create([
            'patient_id' => auth()->id(),
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'status' => $appointmentStatus
        ]);

        
        // Step 6: Save payment
        Payment::create([
            'amount' => $price,
            'payment_method' => $request->payment_method,
            'status' => ($request->payment_method == 'cash') ? 'pending' : 'completed',
            'patient_id' => auth()->id(),
            'doctor_id' => $request->doctor_id,
            'appointment_id' => $appointment->id
        ]);

        return redirect()->route('patient.appointments')->with('success', 'Appointment Booked Successfully');
    } catch (\Throwable $th) {
        return back()->with('error', 'An unexpected error occurred: ' . $th->getMessage());
    }
}


    public function appointmentCancel($id)
    {
        // dd($id);
        $appointment = Appointment::where('id', $id)->where('patient_id', Auth::id())->first();
        if (!$appointment) {
            return back()->with('error', 'User Not Found At This Movement');
        }
        if($appointment->status==='confirmed'){
             return back()->with('error','You Allredy payment. cannot cancell at this movement. please contact admin ');
        } 
        // $doctorAvailability = DoctorAvailability::where('doctor_id',$id);

        // $doctorAvailability->decrement('current_appointments');
        Payment::where('appointment_id',$appointment->id)->delete();
        $appointment->delete();
        return back()->with('success', 'Appointment Remove');


    }
    public function feedbackSubmit(Request $request)
    {
        // Validate request
        $request->validate([
            'doctor_id' => 'required|exists:doctor,users_id',
            'message' => 'required|string'
        ]);
    
        // Find doctor
        $doctor = User::find($request->doctor_id);
        if (!$doctor) {
            return back()->with('error', 'Doctor not found.');
        }
    
        // Create feedback
        Feedback::create([
            'patient_id' => Auth::id(),
            'doctor_id' => $doctor->id,
            'message' => $request->message
        ]);
    
        return back()->with('success', 'Feedback added successfully!');
    }
    

    public function paymentHistory()
    {
        $payments = Payment::where('status','completed')->get();

        return view('patient.payment_details',compact('payments'));
    }



}

