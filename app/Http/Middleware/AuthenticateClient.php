<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use URL;
use App\Admin;

class AuthenticateClient
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
       if (!empty($request->user('client'))) {
            $previous_url = parse_url(URL::previous());
            
            if (substr($previous_url['path'], 0, strlen('/client')) === '/client') {
                $userArray = $request->user('client')->roles();
                Session::put('clientData',$userArray);
                return $next($request);
            }
            else {
                return redirect('/client')->withErrors("Sorry!!");
            }
       }
       else {
           return redirect('/client')->withErrors("Please login to access your account");
       } 
    }
}