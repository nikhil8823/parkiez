<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- CSS -->
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="/css/plugin/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/css/Admin/font-awesome.css" type="text/css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="/css/Admin/AdminLTE.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="/css/Admin/blue.css">
        <!-- custom css -->
        <link rel="stylesheet" href="/css/Admin/skin-red.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    
    <body class="hold-transition login-page">
        @if(session()->has('flash_message'))
        <div class="flash-msg-success login-flash-msg-success ">
            @if((session('flash_message.type')=='success'))
                <div class="alert alert-dismissible fade in success-icon-before" role="alert">
            @else
                <div class="alert alert-dismissible fade in error-icon-before" role="alert">
            @endif
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span></button> {{session('flash_message.message')}}
            </div>
        </div>
        @else
            <div class="flash-msg-success login-flash-msg-success "></div>
        @endif
        <?php Session::forget('flash_message');?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color:#f8f9fa;padding-bottom:25px;
             border=none;border-radius:0;">
            <a class="navbar-brand" href="">
                <img src="{{ url('/images/logo.png') }}" class="img-fluid" alt="logo">
            </a>
        </nav>
        <div class="login-box">
            <div class="login-logo">
                <b>Parkiez</b> Admin Panel
            </div><!-- /.login-logo -->
            @yield('content')
        </div>
    </body>
    
    <!-- JS -->
    <!-- jQuery 2.1.4 -->
    <script src="/js/plugin/jQuery-2.1.4.min.js"></script>
    <script src="/js/plugin/jquery.validate.1.15.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="/js/plugin/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="/js/plugin/icheck.min.js"></script>
    
    @yield('scripts')
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
      setTimeout(function() {
          $('.flash-msg-success').fadeOut('fast');
        }, 5000); // <-- time in milliseconds
    </script>
    
</html>