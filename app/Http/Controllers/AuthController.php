<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        return view('authenticatie.login');
    }
    public function register()
    {
        return view('authenticatie.register');
    }




    public function registerSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:user,admin',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        Auth::login($user);

        return $request->role === 'admin'
            ? redirect()->route('dashboard.admin.index')
            : redirect()->route('dashboard.user.index');
    }
    public function loginCheck(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return back()->withErrors(['email' => 'These credentials do not match any account.'])->withInput();
        }

        $user = Auth::user();

        if($user->role === 'user') {
            return redirect()->route('dashboard.user.index');
        } 
        elseif($user->role === 'admin') {
            return redirect()->route('dashboard.admin.index');
        } else {
            return redirect()->route('dashboard.owner.index');
        }
        // return $user->role === 'admin'
        //     ? redirect()->route('dashboard.admin.index')
        //     : redirect()->route('dashboard.user.index');
    }
}
