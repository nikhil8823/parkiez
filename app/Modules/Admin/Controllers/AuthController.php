<?php

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Admin;
use App\Modules\Admin\Model\Client;

class AuthController extends Controller {
    
    public $redirectTo = '/admin/dashboard';
    public $guard = 'admin';
    use AuthenticatesUsers;
    
    public function __construct() {
        
    }
    
    public function getLogin() {
        
        if (!Auth::check()) {
            return view('Admin::login');
        }
        else {
            return redirect('/admin/dashboard');
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
    
    public function login(Request $request)
    {
        
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
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
        $user = \App\Admin::where($this->username(), $request->{$this->username()})->first();
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
            if (Admin::where('email', '=', $request->email)->exists()) {
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