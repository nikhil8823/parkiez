<?php

namespace App\Modules\Client\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Client;

class AuthController extends Controller {
    
    use AuthenticatesUsers;
    
    public $redirectTo = '/client/myParkings';
    public $guard = 'client';
    
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }
    
    public function getLogin() {
        if (!Auth::guard('client')->check()) {
            return view('Client::login');
        }
        else {
            return redirect('/client/myParkings');
        }
    }
    
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard($this->guard);
    }
       
    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');
        return $credentials;
    }
    
    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];
        
        // Load user from database
        $user = \App\Client::where($this->username(), $request->{$this->username()})->first();
        // Check if user was successfully loaded, that the password matches
        // and active is not 1. If so, override the default error message.
        if ($user && \Hash::check($request->password, $user->password) && $user->is_active != 1) {
            $errors = [$this->username() => 'Your account is not active.'];
        }
        
        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }
    
    public function forgotPassword()
    {
        return view('Admin::forgotPassword');
    }
    
    public function isEmailExist(Request $request)
    {
        if (isset($request->email) && (!empty($request->email))) {
            if (Client::where('email', '=', $request->email)->exists()) {
                echo 'true';
                exit;
            } else {
                echo 'false';
                exit;
            }
        }
        echo 'false';
    }
    
    public function isUniqueClientEmail(Request $request) {
        if (isset($request->email) && (!empty($request->email))) {
            $input['email'] = trim($request->email);

            if (Client::where('email', '=', $input['email'])->exists()) {
                echo 'false';
                exit;
            } else {
                echo 'true';
                exit;
            }
        }
        echo 'true';
    }
}