@extends('layouts.admin.admin')
@section('title')
Manage Parking
@endsection
@section('content')

<section class="content-header">
    <h1> Manage Parking </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Manage Parking</li>
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

                <div class="box-header">                  
                    <div class="pull-right">
                        <!-- Trigger the modal with a button -->
                        <form action="/admin/manageParkingActions" method="post">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="subAction" value="view">
                            <button type="submit" class="btn bg-orange btn-flat margin"><i class="fa fa-plus"></i> Add New Parking</button>
                        </form>
                    </div>
                </div>

                <div class="box-body">
                    <input type='hidden' id='role' value='shipper'>
                    <table id="parkingTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Owner Name</th>
                                <th>Cost</th>
                                <th>Created at</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>

                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
@endsection      
@section('scripts')
<script src="/js/Admin/manageParking.js" type="text/javascript"></script>
@endsection     