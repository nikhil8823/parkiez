@extends('layouts.admin.admin')
@section('title')
Add Client
@endsection
@section('content')

<?php
if (isset($clientDetails)) {

    foreach ($clientDetails as $clientDetail) {

        $client_id = $clientDetail->id;
        $name = $clientDetail->name;
        $phone_number = $clientDetail->phone_number;
        $email = $clientDetail->email;
    }
}
?>
<div id="ManShipAdd" >
    <div class="modal-content">
        <form name="addClientForm" id="addClientForm" action="/admin/manageClientActions" method="POST">
            {{csrf_field()}}
            <div class="modal-header">
                <h4 class="modal-title"><?php echo isset($clientDetails) ? 'Edit' : 'Add New'?> Client</h4>
            </div>
            <div class="modal-body"> 

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <input type="hidden" id="action" name="action" value=<?php echo  isset($clientDetails) ? 'edit' : 'add' ?> >
                        <input type="hidden" name="subAction" value=<?php echo  isset($clientDetails) ? 'update' : "insert" ?>>
                        <input type='hidden' name='client_id' value=<?php echo  isset($client_id) ? $client_id : "" ?>>
                        
                        <h3 class="model-h3-border">Personal Details</h3>
                        <div class="form-group">
                            <label>Name <span class="error-star">*</span></label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" value='<?php echo  ( isset($name) && null != $name) ? $name : '' ?>'>
                        </div> <!-- from group end -->
                        <div class="form-group">
                            <label>Email Address <span class="error-star">*</span></label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="Enter email address" value='<?php echo  ( isset($email) && null != $email) ? $email : '' ?>' <?php echo  isset($clientDetails) ? 'disabled' : '' ?>>
                        </div> <!-- from group end -->
                        <div class="form-group">
                            <label>Phone Number <span class="error-star">*</span></label>
                            <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Enter phone number" value='<?php echo  ( isset($phone_number) && null != $phone_number) ? $phone_number : '' ?>' >
                        </div> <!-- from group end -->
                        <?php if (!isset($clientDetails)) { ?>                          
                            <div class="form-group">
                                <label>Password <span class="error-star">*</span></label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" value=''>
                            </div> <!-- from group end -->

                            <div class="form-group">
                                <label>Confirm Password <span class="error-star">*</span></label>
                                <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Enter confirm password" value=''>
                            </div> <!-- from group end -->
                        <?php } ?>
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
<script src="/js/Admin/manageClient.js" type="text/javascript"></script>
@endsection  
