<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(){
        $user = Auth::user();
        return view('admin.dashboard',compact('user'));
    }

    public function users() {
        $users = User::where('role', '!=', 'admin')->get();

        return view('admin.users',compact('users'));
    }

    public function adminAddUser(Request $request){
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|email',
            'password'=>'required|min:5',
            'role'=>'required',
        ]);
        User::create([
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'role' => $request->role,
      'status' => 'active',
        ]);
        return redirect()->route('admin.users')->with('success','User Add Successfully');
    }

    public function toggleStatus($id)
{
    $user = User::findOrFail($id);
    $user->status = ($user->status === 'active') ? 'inactive' : 'active';
    $user->save();

    return redirect()->route('admin.users')->with('success', 'User status updated successfully.');
}

    
}
