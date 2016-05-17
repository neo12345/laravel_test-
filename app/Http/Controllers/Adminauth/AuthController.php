<?php

namespace App\Http\Controllers\Adminauth;

use App\Admin;
use App\Http\Controllers\Adminauth;
use App\EmailLogin;
use Illuminate\Http\Request;
use Validator;
use Session;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{

    use AuthenticatesAndRegistersUsers,
        ThrottlesLogins;

    protected $redirectTo = '/admin';
    protected $guard = 'admin';

    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect('/admin');
        }

        return view('admin.auth.login');
    }

    public function showRegistrationForm()
    {
        return view('admin.auth.register');
    }

    public function resetPassword()
    {
        return view('admin.auth.passwords.email');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return Admin::create([
                'name' => $data['name'],
                'email' => $data['email'],
        ]);
    }

    /**
     * Login
     * 
     * @param \App\Http\Controllers\Adminauth\Request $request
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:admins,email'
        ]);

        $emailLogin = EmailLogin::createForUser($request->input('email'));

        $url = route('adminauth.email-auth', [ 'token' => $emailLogin->token]);

        $receiver = $request->input('email');

        Mail::send('admin.emails.email-login', ['url' => $url], function ($message) use ($receiver) {
            $message->from('test.mail.laravel@gmail.com', 'Email Login');
            $message->to($receiver)->subject('Email Login');
        });

        Session::flash('flash_message', 'Check email pls!');

        return redirect('/');
    }

    /**
     * authenticate via email
     * 
     * @param type $token
     * @return type
     */
    public function authenticateEmail($token)
    {
        $emailLogin = EmailLogin::validFromToken($token);
        Auth::guard('admin')->login($emailLogin->user);

        Session::flash('flash_message', 'Login successfully!');

        $emailLogin->delete();

        return redirect('/admin');
    }
}
