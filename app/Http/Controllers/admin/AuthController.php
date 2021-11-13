<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {

        return view('admin.login');

    }
    public function login(Request $request)
    {

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/kasirin-toko/subscriptions');
        }else {
            return redirect('/');
        }

    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/');

    }
    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required', 'string', 'email', 'max:255',
            'password' => 'required',
        ]);
        Admin::create([
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return redirect('/');
    }
}
