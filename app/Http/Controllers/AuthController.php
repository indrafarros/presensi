<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    public function login()
    {
        return view('auth.login');
    }

    public function auth(Request $request)
    {
        if (Auth::guard('employee')->attempt(["nik" => $request->nik, "password" => $request->password])) {
            return redirect('/dashboard');
        } else {
            return redirect('/')->with('status', 'Your NIK or password is incorrect');
        }
    }

    public function logout()
    {
        if (Auth::guard('employee')->check()) {
            Auth::guard('employee')->logout();
            return redirect('/');
        }

        return redirect('/');
    }

    public function profile()
    {
        if (Auth::guard('employee')) {
            $user = Employees::where('nik', Auth::guard()->user()->nik)->with(['roles' => function ($query) {
                $query->select('id', 'name');
            }])->first(['nik', 'name', 'role_id', 'phone']);
            return view('dashboard.profile', compact('user'));
        }
    }
}
