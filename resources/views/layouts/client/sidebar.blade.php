<?php
$userArr = \Illuminate\Support\Facades\Session::get('clientData');
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
            <a href="{{url('/client/myParkings')}}" id="myParkings">
                <i class="fa fa-tachometer"></i>
                <span>My Parking</span>
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