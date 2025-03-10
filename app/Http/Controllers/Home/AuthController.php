<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Mail;
use Stevebauman\Location\Facades\Location;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::guard('web')->check()) {

            return redirect()->route('welcome.index');
        }

        return view('home.auth.login');

    } //end of index login function

    public function register()
    {
        if (Auth::guard('web')->check()) {

            return redirect()->route('welcome.index');
        }

        return view('home.auth.register');

    } //end of index register function

    public function store_login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        try {

            if (Auth::guard('web')->check()) {

                return redirect()->route('welcome.index');

            } else {

                if (User::where('email', $request->email)->first()) {
                    $remember_me = $request->has('remember') ? true : false;
                    if (\Auth::guard('web')->attempt([
                        'email'    => $request->email,
                        'password' => $request->password], $remember_me)) {

                        notify()->success(__('dashboard.login_successfully'));
                        return redirect()->route('profile.index');

                    } else {

                        return back()->withErrors([
                            'password' => 'The password is incorrect',
                        ]);

                    } //end of attempt

                } else {

                    return back()->withErrors([
                        'email' => 'The email is incorrect',
                    ]);

                } //end of email

            } //end of if auth

        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        } //end of try catch

    } //end of login store function

    public function store_register(Request $request)
    {
        
        $request->validate([
            'name'     => ['required', 'max:15'],
            'username' => ['required', 'unique:users', 'max:20'],
            'phone'    => ['required', 'max:15', 'min:9'],
            'email'    => ['required', 'email', 'unique:users', 'max:25'],
            'password' => ['required', 'confirmed', 'max:20'],
        ]);

        try {

            $request_data             = $request->except('password_confirmation', 'remember');
            $request_data['password'] = bcrypt($request->password);

            $position = \Http::get('http://ip-api.com/json/');
           
            if ($position) {

                $request_data['country'] = $position['country'];
                $request_data['city']    = $position['regionName'];
                $request_data['state']   = $position['regionName'];
                $request_data['title']   = $position['city'];
                
            } 

            if (Auth::guard('web')->check()) {

                return redirect()->route('welcome.index');

            } else {

                $user = User::create($request_data);
                $user->attachRole('clients');

                $remember_me = $request->has('remember') ? true : false;
                auth()->login($user, $remember_me);

                $user = Notification::create([
                    'title_ar' => 'تم انشاء حساب جديد',
                    'title_en' => 'created New account',
                    'user_id'  => $user->id,
                ]); //end of create

                \Mail::to($request->email)->send(new \App\Mail\NotyEmail($user));

                notify()->success(__('dashboard.added_successfully'));
                return redirect()->route('profile.index');

            } //end of if auth

        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        } //end of try catch

    } //end of login store function

    public function user_logout()
    {
        Auth::guard('web')->logout();

        notify()->success(__('dashboard.logoute_successfully'));
        return redirect()->route('home.login');

    } //end of logout user

} //end of controller
