<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use URL;
use App\Admin;

class AuthenticateAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       if (!empty($request->user('admin'))) {
            $previous_url = parse_url(URL::previous());
            
            if (substr($previous_url['path'], 0, strlen('/admin')) === '/admin') {
                $userArray = $request->user('admin')->roles();
                Session::put('adminData',$userArray);
                return $next($request);
            }
            else {
                return redirect('/admin')->withErrors("Sorry!!");
            }
       }
       else {
           return redirect('/admin')->withErrors("Please login to access your account");
       } 
    }
}