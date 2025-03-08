<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

            ]);
            
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
}

