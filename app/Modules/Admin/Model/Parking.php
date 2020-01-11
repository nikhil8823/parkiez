<?php

namespace App\Modules\Admin\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Parking extends Model {

    protected $parkingTable = 'parkings';
    protected $clientTable = 'clients';

    public function getGridData($request, $dataTableObj) {

        $sTable = "$this->parkingTable u JOIN $this->clientTable cd ON u.client_id = cd.id";

        $aColumns = array(
            'u.id id',
            'u.title title',
            'cd.name name',
            'u.cost',
            'DATE_FORMAT(DATE(u.created_at),"%d-%m-%Y") date',
            'CASE WHEN u.status = 1 THEN "Active" WHEN u.status = 0 THEN "Inactive" ELSE "" END as "Status"',
            "CONCAT(\"
                <button class='btn btn-default btn-sm btn-custome view_request pull-left' style=' display: none; data-original-title='View'
                        data-toggle='tooltip' title='' data-placement='top' data-id='\",u.id,\"'><i class='fa fa-eye'></i></button>
                        <form action='/admin/manageParkingActions' method='post' style=' display: inline-block; float: left;'>
                        <input type='hidden' name='_token' value='".csrf_token()."'>
                            <input type='hidden' name='action' value='edit'>
                            <input type='hidden' name='subAction' value='view'>
                            <input type='hidden' name='parking_id' value='\",u.id,\"'>                        
                         <button type='submit' class='btn btn-default btn-sm btn-custome edit_request' data-original-title='Edit'
                         data-toggle='tooltip' title='' data-placement='top' data-id='\",u.id,\"'><i class='fa fa-pencil'></i></button>   
                        </form>                      

                      <form action='/admin/manageParkingActions' method='post' style=' display: inline-block; float: left;'>
                      <input type='hidden' name='_token' value='".csrf_token()."'>
                      <input type='hidden' name='action' value='delete'>
                      <input type='hidden' name='subAction' value='\",IF(u.status = 1, 'deActivate', 'activate'),\"'>
                      <input type='hidden' name='parking_id' value='\",u.id,\"'>
                      <button type='submit' data-id='\",u.id,\"' data-toggle='tooltip' data-placement='top'
                      class='btn \",IF(u.status = 1, 'btn-danger', 'btn-default'),\" btn-sm btn-custome edit' title='\",IF(u.status = 1, 'Inactive', 'Active'),\"' > 
                      <i class='fa \",IF(u.status = 1, 'fa-ban', 'fa-check'),\"' aria-hidden='true'></i> </button>                      
                      </form>

                 \" )
            as 'act'");

        $aColumnsSE = array('u.id', 'u.title', 'cd.name', 'u.cost', 'DATE_FORMAT(DATE(u.created_at),"%d-%m-%Y")', 'u.status');
        $aColumnsOR = array('id', 'title', 'cd.name', 'cost', 'date', 'Status');
        $aColumnsD = array('id', 'title', 'name', 'cost', 'date', 'Status', 'act');
        $where = 'u.id is not null';
        $dataTableObj->getData($request, $sTable, $aColumns, $aColumnsSE, $aColumnsOR, $aColumnsD, $where, null, 0, null);
    }
    
    public function insertParking($request) {
        // O means Inactive 1 means Active
        // 0 not delete, 1 means delete
        $requestObj = new Parking();
        $requestObj->title = $request['title'];
        $requestObj->client_id = $request['client_id'];
        $requestObj->created_by = $request['client_id'];
        $requestObj->description = $request['description'];
        $requestObj->slots = $request['slots'];
        $requestObj->cost = $request['cost'];
        $requestObj->latitude = $request['latitude'];
        $requestObj->longitude = $request['longitude'];
        $requestObj->radius = $request['radius'];
        $requestObj->status = "0";
        $requestObj->is_delete = "0";
        $requestObj->created_at =  date("Y-m-d H:i:s");
       
        $status = $requestObj->save();
        return $status;
    }
    
    public function getParkingDetails($parkingId) {
        
        $parkingObj = DB::table('parkings')
                    ->select('id','client_id','title', 'description', 'slots', 'cost', 'latitude', 'longitude', 'radius')
                    ->where('id','=',$parkingId)
                    ->get();
        
        if($parkingObj->count() > 0) {
            return $parkingObj;
        }
        return false;        
    }
    
    public function updateParkingDetails($request) {
        var_dump(Auth::check());die;
        $updateClient = DB::table('parkings')
            ->where('id', (int) $request->get('parking_id'))
            ->update(['title' => $request->get('title'),
                      'client_id' => $request->get('client_id'),
                      'description' => $request->get('description'),
                      'slots' => $request->get('slots'),
                      'cost' => $request->get('cost'),
                      'latitude' => $request->get('latitude'),
                      'longitude' => $request->get('longitude'),
                      'radius' => $request->get('radius'),
                    ]);
        return $updateClient;        
    }
    
    public function deActivateParking($request) {
        // O means Inactive 1 means Active
        $aprkingObj = DB::table('parkings');
        $aprkingObj->where('id', (int) $request->get('parking_id'));
        if ('activate' == $request->get('subAction')) {
            $aprkingObj->update(['status' => 1]);
        } elseif ('deActivate' == $request->get('subAction')) {
            $aprkingObj->update(['status' => 0]);
        }        
    }
}
