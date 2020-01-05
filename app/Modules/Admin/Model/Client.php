<?php

namespace App\Modules\Admin\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Client extends Model {

    protected $userTable = 'clients';
    

    public function getGridData($request, $dataTableObj) {
        //DB::enableQueryLog();
        $sTable = "$this->userTable u";

        $aColumns = array(
            'u.id id',
            'u.name name',
            'u.email email',
            'u.phone_number',
            'DATE_FORMAT(DATE(u.created_at),"%d-%m-%Y") date',
            'CASE WHEN u.status = 1 THEN "Active" WHEN status = 0 THEN "Inactive" ELSE "" END as "Status"',
            "CONCAT(\"
                <button class='btn btn-default btn-sm btn-custome view_request pull-left' style=' display: none; data-original-title='View'
                        data-toggle='tooltip' title='' data-placement='top' data-id='\",u.id,\"'><i class='fa fa-eye'></i></button>
                        <form action='/admin/manageClientActions' method='post' style=' display: inline-block; float: left;'>
                            <input type='hidden' name='action' value='edit'>
                            <input type='hidden' name='subAction' value='view'>
                            <input type='hidden' name='client_id' value='\",u.id,\"'>                        
                         <button type='submit' class='btn btn-default btn-sm btn-custome edit_request' data-original-title='Edit'
                         data-toggle='tooltip' title='' data-placement='top' data-id='\",u.id,\"'><i class='fa fa-pencil'></i></button>   
                        </form>                      

                      <form action='/admin/manageClientActions' method='post' style=' display: inline-block; float: left;'>
                      <input type='hidden' name='action' value='delete'>
                      <input type='hidden' name='subAction' value='\",IF(status = 1, 'deActivate', 'activate'),\"'>
                      <input type='hidden' name='client_id' value='\",u.id,\"'>
                      <button type='submit' data-id='\",u.id,\"' data-toggle='tooltip' data-placement='top'
                      class='btn \",IF(status = 1, 'btn-danger', 'btn-default'),\" btn-sm btn-custome edit' title='\",IF(status = 1, 'Inactive', 'Active'),\"' > 
                      <i class='fa \",IF(status = 1, 'fa-ban', 'fa-check'),\"' aria-hidden='true'></i> </button>                      
                      </form>

                 \" )
            as 'act'");

        $aColumnsSE = array('u.id', 'u.name', 'u.email', 'u.phone_number', 'DATE_FORMAT(DATE(u.created_at),"%d-%m-%Y")', 'u.status');
        $aColumnsOR = array('id', 'name', 'email', 'phone_number', 'date', 'Status');
        $aColumnsD = array('id', 'name', 'email', 'phone_number', 'date', 'Status', 'act');
        $where = 'u.id is not null';
        $dataTableObj->getData($request, $sTable, $aColumns, $aColumnsSE, $aColumnsOR, $aColumnsD, $where, null, 0, null);
    }
    
    public function insertClient($request) {
        $requestObj = new Client();
        $requestObj->name = $request['name'];
        $requestObj->email = $request['email'];
        $requestObj->password = bcrypt($request['password']);
        $requestObj->status = isset($request['subAction'])?"1":"0";
        $requestObj->phone_number = $request['phone_number'];
        $requestObj->is_delete = "0";
        $requestObj->created_at =  $currentDate = date("Y-m-d H:i:s");
       
       $status = $requestObj->save();
        
       if($status == 1){
            return array('clientId'=>(string)$requestObj->id,
                'email'=>$requestObj->email,'password' => $request['password']);
       }else{
            return 0;
       }
    }
    
    public function getClient($clientId) {
        $clientObj = DB::table('clients')
                    ->select('id','name','email', 'phone_number')
                    ->where('id','=',$clientId)
                    ->get();
        return $clientObj;
    }
    
    public function updateClient($request) {
        $updateClient = DB::table('clients')
            ->where('id', (int) $request->get('client_id'))
            ->update(['name' => $request->get('name'), 'phone_number' => $request->get('phone_number')]);
        return $updateClient;
    }
    
    public function deActivateClient($request) {
        // O means Inactive 1 means Active
        $clientObj = DB::table('clients');
        $clientObj->where('id', (int) $request->get('client_id'));
        if ('activate' == $request->get('subAction')) {
            $clientObj->update(['status' => 1]);
        } elseif ('deActivate' == $request->get('subAction')) {
            $clientObj->update(['status' => 0]);
        }
    }
    
    public function getClientList() {
        $clientObj = DB::table('clients');
        $clientObj->select('id', 'name');
        $clientObj->where('status', '=', 1);
        $clientObj->where('is_delete', '=', 0); // 0 not delete, 1 means delete
        $clientList = $clientObj->get();
        return $clientList;
    }
}
