<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\UserConfirms;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Session;
use Mail;
use Auth;

class AuthController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Registration & Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users, as well as the
      | authentication of existing users. By default, this controller uses
      | a simple trait to add these behaviors. Why don't you explore it?
      |
     */

use AuthenticatesAndRegistersUsers,
    ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
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
                'password' => 'required|min:6|confirmed',
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
        return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
        ]);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|exists:users,email',
            'password' => 'required',
        ]);

        $user = User::where('email', '=', $request->email)->first();

        $confirm = UserConfirms::where('user_id', '=', $user['id'])
            ->where('action', '=', 'register')
            ->first();

        if ($confirm) {
            Session::flash('flash_message', 'Confirm email pls.');
            
            return redirect('/');
        }
        
        Auth::login($user);
        
        Session::flash('flash_message', 'Login Successfully.');
        
        return redirect('/');
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $user = User::where('email', '=', $request->email)->first();

        $token = str_random(30);

        UserConfirms::create([
            'user_id' => $user['id'],
            'token' => $token,
            'action' => 'register'
        ]);

        $url = route('auth.confirm', $token);

        Mail::send('auth.emails.email-register', ['url' => $url], function ($m) use ($request) {
            $m->from('test.mail.laravel@gmail.com', 'MyApp');
            $m->to($request->email)->subject('User Confirmation');
        });

        Session::flash('flash_message', 'Email has been sent.');
        return redirect('/');
    }

    public function confirm($token)
    {
        $action = UserConfirms::where('token', '=', $token)->firstorfail();

        $action->delete();

        return redirect('/login');
    }
}
