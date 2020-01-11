@extends('layouts.client.app')
@section('title')
    Log In
@endsection

@section('content')
<div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
    <form id="client_login_form" name="client_login_form" action="client/login" method="post">
        {{ csrf_field() }}
        <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
            <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email Address" autofocus>
            @if ($errors->has('email'))
            <span class="help-block">
                <label for="email" generated="true" class="error" style="display: inline-block;">{{ $errors->first('email') }}</label>
            </span>
            @endif
        </div>
        
        <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
            <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password">
            @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif
        </div>
        
        <div class="row">
            <div class="col-xs-4">
                <button type="submit" id="signIn" name="signIn" class="btn btn-block bg-orange btn-flat">SIGN IN</button>
            </div><!-- /.col -->
            
            <div class="col-xs-8 text-right">
                <a class="color-" href="/client/forgotPassword">Forgot password?</a>
            </div><!-- /.col -->
        </div>
    </form>

</div><!-- /.login-box-body -->
@endsection
@section('scripts')
<script src="/js/Client/clientLogin.js"></script>
@endsection