@extends('layouts.client.client')
@section('title')
My Parkings
@endsection
@section('content')

<section class="content-header">
    <h1> My Parkings </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Manage Clients</li>
    </ol>
</section>
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
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    
               <?php
               
               if(empty($myParkings)) {
                   echo "No Parking found";
               }
               else {
                   foreach($myParkings as $myparking) {
                    $parkingId = $myparking->id;
               ?>
               <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="image-flip">
                    <div class="mainflip">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p>
                                        <img class=" img-fluid" width="120px" height="120px" src="{{ url('/images/client/car_parking.png') }}" alt="card image">
                                    </p>
                                    <h4 class="card-title">
                                        <a href="{{ url('/client/parkingDetail')}}/{{ $parkingId }}" class="btn btn-primary btn-sm">
                                            <?php echo $myparking->title; ?>
                                        </a>
                                    </h4>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
               <?php }
               }
               ?>
                    
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
@endsection      
@section('scripts')
@endsection     