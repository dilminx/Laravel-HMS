<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  public function register(Request $request)
  {
    $request->validate([
      'firstName' => 'required',
      'lastName' => 'required',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|min:5',

    ]);
    User::create([
      'first_name' => $request->firstName,
      'last_name' => $request->lastName,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'status' => 'active',
      'role' => 'patient'
    ]);

    return redirect()->route('login')->with('success', 'Register_successfully');


  }
  public function login(Request $request)
  {

    $request->validate([
      'email' => 'required|email',
      'password' => 'required',
    ]);
    
    // dd($request);

    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
      $user = Auth::user();
      switch ($user->role) {
        case 'admin':
          return redirect()->route('admin.dashboard')->with('success', 'welcome Admin dashboard');
        case 'doctor':
          return redirect()->route('doctor.dashboard')->with('success', 'welcome Doctor dashboard');
        case 'patient':
          return redirect()->route('patient.dashboard')->with('success', 'welcome Patient dashboard');
        case 'lab_assistant':
          return redirect()->route('lab.dashboard')->with('success', 'welcome Lab dashboard');
        default:
          Auth::logout();
          return redirect()->route('login.view')->with('error', 'Unauthorized Access');
      }
    }
    return redirect()->back()->with('error', 'invalid Credintials');
  }

  public function logout(Request $request)
  {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')->with('success', 'Logout Success');
  }
}
