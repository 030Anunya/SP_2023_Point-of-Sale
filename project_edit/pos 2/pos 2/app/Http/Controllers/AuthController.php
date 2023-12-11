<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('pages.auth.login');
    }
    public function loginpost(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'กรุณากรอกชื่อผู้ใช้',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
        ]);

        if (Auth::attempt($credentials)) {
            if (auth()->user()->status == 1) {
                $request->session()->regenerate();
                return redirect()->intended(route('listsale.index'))->with('message', 'เข้าสู่ระบบสำเร็จ');

            } else {
                Auth::logout();
                return back()->withErrors([
                    'loginError' => 'บัญชีนี้ถูกระงับการใช้งาน',
                ]);
            }
        }

        return back()->withErrors([
            'email' => 'ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง',
        ])->onlyInput('email');
    }

    // public function register(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'email' => 'required',
    //         'password' => 'required'
    //     ]);
    //     $user = new User();
    //     $user->name = $request->input('name');
    //     $user->email = $request->input('email');
    //     $user->password = bcrypt($request->input('password'));
    //     $user->save();
    //     return redirect(route('register'))->with('error', 'Register failed, try again.');
    //     if (!$user) {
    //     }
    //     return redirect(route('products.index'))->with('success', 'Register success');
    // }

    public function logout()
    {
        Session::flush();
        Auth::logout(); // Logs the user out
        return redirect(route('login'))->with('message', 'ออกจากระบบเรียบร้อย'); // Redirect to the login page (or an
    }
}
