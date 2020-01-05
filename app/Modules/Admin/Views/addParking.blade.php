@extends('layouts.admin.admin')
@section('title')
Add Parking
@endsection
@section('content')

<?php

if (isset($parkingDetails)) {

    foreach ($parkingDetails as $parkingDetail) {

        $parkingId = $parkingDetail->id;
        $title = $parkingDetail->title;
        $clientId = $parkingDetail->client_id;
        $description = $parkingDetail->description;
        $slots = $parkingDetail->slots;
        $cost = $parkingDetail->cost;
        $latitude = $parkingDetail->latitude;
        $longitude = $parkingDetail->longitude;
        $radius = $parkingDetail->radius;
    }
}
?>
<div id="ManShipAdd" >
    <div class="modal-content">
        <form name="addClientForm" id="addParkingForm" action="/admin/manageParkingActions" method="POST">
            {{csrf_field()}}
            <div class="modal-header">
                <h4 class="modal-title"><?php echo isset($parkingDetails) ? 'Edit' : 'Add New'?> Parking</h4>
            </div>
            <div class="modal-body"> 

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <input type="hidden" id="action" name="action" value=<?php echo  isset($parkingDetails) ? 'edit' : 'add' ?> >
                        <input type="hidden" name="subAction" value=<?php echo  isset($parkingDetails) ? 'update' : "insert" ?>>
                        <input type='hidden' name='client_id' value=<?php echo  isset($parkingId) ? $parkingId : "" ?>>
                        
                        <h3 class="model-h3-border">Parking Details</h3>
                        <div class="form-group">
                            <label>Title <span class="error-star">*</span></label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="Enter title" value='<?php echo  ( isset($title) && null != $title) ? $title : '' ?>'>
                        </div> <!-- from group end -->
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12">
                                    <label>Select Owner <span class="error-star">*</span></label>
                                    @if(!$clientList->isEmpty())
                                    <select class="form-control " name="client_id" id="client_id">
                                        <option value='Select Owner'>Select Owner</option>
                                        @foreach($clientList as $client)
                                        <option value="{{ $client->id }}" <?php echo  ( isset($clientId) && $client->id == $clientId ) ? 'selected' : '' ?> >{{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                    @endif                                        
                                </div> <!-- col end -->
                            </div> <!-- row end -->                    
                        </div> <!-- from group end -->
                        
                        <div class="form-group">
                            <label>Description<span class="error-star">*</span></label>
                            <textarea class="form-control" rows="3" name="description" placeholder="Enter description" maxlength="256"><?php echo isset($description) && !empty($description) ? $description : ''; ?></textarea>
                        </div> <!-- from group end -->

                        <div class="form-group">
                            <label>Slot Details<span class="error-star">*</span></label>
                            <textarea class="form-control" rows="3" name="slots" placeholder="Enter slots details" maxlength="256"><?php echo isset($slots) && !empty($slots) ? $slots : ''; ?></textarea>
                        </div> <!-- from group end -->
                        <div class="form-group">
                            <label>Cost <span class="error-star">*</span></label>
                            <input type="text" class="form-control" name="cost" id="cost" placeholder="Enter cost" value='<?php echo  ( isset($cost) && null != $cost) ? $cost : '' ?>'>
                        </div> <!-- from group end -->
                        <div class="form-group">
                            <label>Latitude</label>
                            <input type="text" class="form-control" name="latitude" id="latitude" placeholder="Enter latitude" value='<?php echo  ( isset($latitude) && null != $latitude) ? $latitude : '' ?>'>
                        </div> <!-- from group end -->
                        <div class="form-group">
                            <label>Longitude</label>
                            <input type="text" class="form-control" name="longitude" id="longitude" placeholder="Enter longitude" value='<?php echo  ( isset($longitude) && null != $longitude) ? $longitude : '' ?>'>
                        </div> <!-- from group end -->
                        <div class="form-group">
                            <label>Radius</label>
                            <input type="text" class="form-control" name="radius" id="radius" placeholder="Enter radius" value='<?php echo  ( isset($radius) && null != $radius) ? $radius : '' ?>'>
                        </div> <!-- from group end -->
                    </div> <!-- col 12 -->
                </div> <!-- row -->
            </div> <!-- model body end -->

            <div class="modal-footer">                            
                <button type="submit" class="btn btn-default btn-save bg-orange">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection      
@section('scripts')
<script src="/js/Admin/manageParking.js" type="text/javascript"></script>
@endsection  
