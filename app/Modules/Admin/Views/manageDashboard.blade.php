@extends('layouts.admin.admin')
@section('title')
Manage Dashboard
@endsection
@section('content')
<section class="content-header">
    <h1> Dashboard</h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3 id="usersRegistered"></h3>
                    <p>Number Of Parking Owners</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                </div>
                <p href="#" class="small-box-footer">&nbsp;  </p>
            </div>
        </div> <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3 id="shipmentsPosted"></h3>
                    <p>Number Of Parking Slots</p>
                </div>
                <div class="icon">
                    <i class="fa fa-truck" aria-hidden="true"></i>
                </div>
                <p href="#" class="small-box-footer">&nbsp;  </p>
            </div>
        </div> <!-- ./col -->
        <!-- ./col -->
    </div> <!-- row end -->
</section> <!-- /.content -->
@endsection
@section('scripts')
<script src="/js/Admin/manageDashboard.js" type="text/javascript"></script>
<script type="text/javascript">
var type = '<?php echo Config::get('constants.duration_type.day'); ?>';
</script>
@endsection