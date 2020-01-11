<?php

namespace App\Modules\Client\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Parking extends Model {

    protected $parkingTable = 'parkings';
    protected $clientTable = 'clients';
    
    public function getMyParkings() {
        
        $currentClientId = Auth::guard('client')->id();
        $parkingObj = DB::table('parkings')
                    ->select('id','client_id','title', 'description', 'slots', 'cost', 'latitude', 'longitude', 'radius')
                    ->where('client_id','=',$currentClientId)
                    ->where('status','=','1')
                    ->where('is_delete','=','0')
                    ->get();

        if($parkingObj->count() > 0) {
            return $parkingObj;
        }
        return false;         
    }
    
    public function isMyParking($parkingId) {
        
        $currentClientId = Auth::guard('client')->id();
        $parkingObj = DB::table('parkings')
                    ->select('id','client_id','title', 'description', 'slots', 'cost', 'latitude', 'longitude', 'radius')
                    ->where('client_id','=',$currentClientId)
                    ->where('status','=','1')
                    ->where('is_delete','=','0')
                    ->where('id','=',$parkingId)
                    ->first();

        if(!empty($parkingObj)) {
            return $parkingObj;
        }
        return false;         
    }
}
