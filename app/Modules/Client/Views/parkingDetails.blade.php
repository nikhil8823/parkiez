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
    <?php Session::forget('flash_message'); ?>'

    <?php
    $parking_arr = explode("-", $parkingData->slots);
    $max_rows = count($parking_arr);
    $max_cols = 0;
    for ($i = 0; $i < count($parking_arr); $i++) {
        if ($max_cols < strlen($parking_arr[$i])) {
            $max_cols = strlen($parking_arr[$i]);
        }
    }
    $bookedArray = [];
    foreach($bookingDetails as $booking) {
        $bookedArray[$booking->slot_id] = $booking->car_number;
    }
    ?>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">

                        <div style="margin-bottom:40px;">
                            <h4 class="float-left"><?php echo $parkingData->title; ?></h4>

                            <div class="redindications float-right">
                                <div class="status" onclick="freeParking()">Out Entry / Generate Bill</div>
                            </div>

                            <div class="indications float-right">
                                <div class="status"><img src="{{ url('/images/client/available.png') }}" alt="available"> Available</div>
                                <div class="status"><img src="{{ url('/images/client/booked.png') }}" alt="booked"> Booked</div>
                                <div class="status"><img src="{{ url('/images/client/notAvailable.png') }}" alt="notAvailable"> Not Available</div>
                            </div>
                            <div class="clearfix"></div>
                        </div>


                        <div class="parkingSlotsWraper">
                            <div class="mainWrap">
                                <?php
                                for ($i = 0; $i < $max_rows; $i++) {
                                    echo "<div class=\"slotWrapper\">";
                                    for ($j = 0; $j < $max_cols; $j++) {
                                        $slot_id = "R" . $i . "C" . $j;
                                        if ($parking_arr[$i][$j]) {
                                            ?>
                                            <?php if (array_key_exists($slot_id, $bookedArray)) { ?>
                                                <div class="parkingslot booked parking_model" data-toggle="modal" data-target="#Search" 
                                                     data-slot-id="<?php echo $slot_id; ?>" 
                                                     data-parking-type="free" data-parking-id="<?php echo $parkingData->id; ?>"
                                                     data-car-data="<?php echo $bookedArray[$slot_id]; ?>"
                                                     > <p><?php echo $slot_id; ?></p> </div>

                                            <?php } else {
                                                ?>
                                                <div class="parkingslot available parking_model" data-slot-id="<?php echo $slot_id; ?>" 
                                                     data-parking-type="book" data-parking-id="<?php echo $parkingData->id; ?>" > <p><?php echo $slot_id; ?></p> </div>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <div class="parkingslot notAvailable"> <p><?php echo $slot_id; ?></p> </div>
                                            <?php
                                        }
                                    }
                                    echo "</div>";
                                }
                                ?>

                            </div>

                        </div>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->


    <!-- Modal -->
    <div class="modal fade" id="open_parking_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header paking_model_header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Car Details</h4>
                </div>
                <div class="modal-body">
                    <form class="parking-model-form-container" id="book_parking_form" name="book_parking_form" method="post" action="/client/bookingAction">
                        <table class="content" style="width: 100%;">
                            <tbody>
                                <input name='parking_id' id="parking_id" value="<?php echo $parkingData->id; ?>" type="hidden">
                                <input name='parking_type' id="parking_type" value="" type="hidden">
                                <input name='slot_id' id="slot_id" value="" type="hidden">
                                <tr style="width: 100%;">
                                    <td class="pad-10" style="text-align: center;vertical-align: middle;">
                                        <input name='state_name' id="state_name" type="text" value="MH" class='popup_text'>
                                    </td>
                                    <td class="pad-10">
                                        <input name='state_code' id='state_code' type="text" value="12" class='popup_text'>
                                    </td>
                                    <td class="pad-10">
                                        <input name='car_series' id="car_series" type="text" value="" placeholder="AB" class='popup_text'>
                                    </td>
                                    <td class="pad-10">
                                        <input name='car_number' id="car_number" type="text" value="" placeholder="2142" class='popup_text'>
                                    </td>
                                </tr>
                                <tr id="price_details" style="display:none;">
                                    <td class="price_details" colspan="4" style="text-align: center; height: 60px;">
                                        <p style="text-align: center;display: inline;">Bill Amount: </p>
                                        <input name="cost" id="parking_cost" type="text" value="" style="width:50%;height: 50px;font-size: 20px;text-align: center;">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="text-align: center; height: 60px;">
                                        <input type="submit" class="btn booking_form_submit" style="text-align: center;width: 30%;" value="Submit">
                                        <button type="button" class="btn cancel clear-button" style="text-align: center;width: 30%;">Close</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->

    @endsection      
    @section('styles')
    <link href="/css/Client/parking.css" rel="stylesheet">
    @endsection  
    @section('scripts')
    <script src="/js/Client/parkingDetails.js" type="text/javascript"></script>
    @endsection  