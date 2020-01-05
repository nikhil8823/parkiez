<?php
$userArr = \Illuminate\Support\Facades\Session::get('adminData');
$username = str_limit($userArr->name, 12);
$email = $userArr->email;
?>
<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">

        <div class="pull-left info" style="position:relative;">
            <p>{{$username}}</p>
            {{$email}}
        </div>
    </div>

    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
        <li>
            <a href="{{url('/admin/dashboard')}}" id="dashboard">
                <i class="fa fa-tachometer"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{route('manageClient')}}" id="manageClient">                
                <i class="fa fa-truck" aria-hidden="true"></i> <span>Manage Clients</span>
            </a>
        </li>
        <li>
            <a href="{{route('manageParking')}}" id="manageParking">                
                <i class="fa fa-truck" aria-hidden="true"></i> <span>Manage Parking</span>
            </a>
        </li>
        <li>
            <a href="/logout">
                <i class="fa fa-sign-out" aria-hidden="true"></i> <span>Sign Out</span>
            </a>
        </li>
    </ul>
</section>
<!-- /.sidebar -->