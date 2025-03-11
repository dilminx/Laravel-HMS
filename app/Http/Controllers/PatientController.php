<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
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
    public function index(){
        $patient = Patient::where('users_id',Auth::id())->first();
        return view('patient.dashboard',compact('patient'));
    }
    public function patientUpdate(Request $request){
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
            return redirect()->back()->with('error', 'Somthing Went Wrong'.$e->getMessage());
        }
       }

       public function medicalHistoryView(){
        $medicals = MedicalHistory::where('patient_id', Auth::id())->get();
        return view('patient.medical_history',compact('medicals'));
       }
      
       public function doctorList()
    {
        $categories = DoctorCategory::with('doctors.user')->get(); 
        return view('patient.doctor_list', compact('categories'));
    }
    public function showDoctor($id) {
        $doctor = Doctor::with(['user', 'category', 'availability'])->findOrFail($id);
        $doc_id = Doctor::find($id);
        $users_id = $doc_id->users_id;
        // dd($users_id);

        $feedbacks = Feedback::where('doctor_id',$users_id)->get();
        $myappointments = Appointment::where('patient_id',Auth::id())->get();
        // dd($myappointments);
        return view('patient.doctor_view', compact('doctor','feedbacks','myappointments'));
    }
    public function bookAppointment(Request $request) {
        try {
            $request->validate([
                'doctor_id' => 'required|exists:doctor,id',
                'appointment_date' => 'required|date'
            ]);
        
            $doctorAvailability = DoctorAvailability::where('doctor_id', $request->doctor_id)
                ->where('available_date', $request->appointment_date)
                ->first();
        
            if (!$doctorAvailability || !$doctorAvailability->hasAvailableSlots()) {
                return back()->with('error', 'No available slots on this date.');
            }
        
            // Create the appointment
            Appointment::create([
                'patient_id' => auth()->id(),
                'doctor_id' => $request->doctor_id,
                'appointment_date' => $request->appointment_date,
                'status' => 'pending'
            ]);
        
            // Update available slots count
            $doctorAvailability->increment('current_appointments');
        
            return back()->with('success', 'Appointment booked successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', 'Appointment cannot Booked');

        }
    }
    public function appointmentCancel($id){
        $appointment = Appointment::where('id',$id)->where('patient_id',Auth::id())->first();
        if(!$appointment){
            return back()->with('error', 'User Not Found At This Movement');
        }
        $appointment->delete();
        return back()->with('success', 'Appointment Remove');


    }
    public function feedbackSubmit(Request $request){
        $request->validate([
            'doctor_id'=>'required',
            'message'=>'required'
        ]);
        $doctor = Doctor::find($request->doctor_id);  
            //   dd($doctor);
        Feedback::create([
            'patient_id'=>Auth::id(),
            'doctor_id'=>$doctor->users_id,
            'message'=>$request->message
        ]);
        return back()->with('success', 'Feedback add successfully!');
    }
    
    

}

