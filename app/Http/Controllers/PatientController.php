<?php

namespace App\Http\Controllers;

use App\Models\MedicalHistory;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
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
       public function doctorList(){
        $doctors = User::where('role','doctor')->with('doctor','doctor_category')->get();
        return view('patient.doctor_list',compact('doctors'));
       }
}

