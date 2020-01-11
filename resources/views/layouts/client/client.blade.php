<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>
        
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="/css/plugin/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/css/Admin/font-awesome.css" type="text/css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="/css/Admin/dataTables.bootstrap.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="/css/Admin/AdminLTE.css">
        <link rel="stylesheet" href="/css/Admin/skin-red.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        
        @yield('styles')
    </head>
    <body class="hold-transition skin-red fixed sidebar-mini">
        <div class="wrapper">

            @include('layouts.client.header')
            
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                @include('layouts.client.sidebar')
            </aside>
            
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        @yield('page_title')
                    </h1>
                    <ol class="breadcrumb">

                    </ol>
                </section>
                @if(session()->has('flash_message'))
                <div class="flash-msg-success">
                    @if((session('flash_message.type')=='success'))
                    <div class="alert alert-warning1 alert-dismissible fade in success-icon-before" role="alert">
                        @else
                        <div class="alert alert-warning1 alert-dismissible fade in error-icon-before" role="alert">
                            @endif
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span></button> {{session('flash_message.message')}}
                        </div>
                    </div>
                    @else
                    <div class="flash-msg-success"></div>
                    @endif
                    <?php Session::forget('flash_message'); ?>

                @yield('content')
            </div>
            @include('layouts.client.footer')
            @yield('scripts')
            <script>
                setTimeout(function() {
                  $('.flash-msg-success').fadeOut('fast');
                }, 5000); // <-- time in milliseconds
                var appTimezone = "<?php echo Config::get('app.timezone'); ?>";
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });                
            </script>
    </body>
</html>