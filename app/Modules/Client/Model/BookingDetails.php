<?php

namespace App\Modules\Client\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BookingDetails extends Model {

    protected $bookingTable = 'booking_details';
    
    public function getBookingDetails($parkingId) {
        
        $bookingObj = DB::table('booking_details')
                    ->select('*')
                    ->where('parking_id','=',$parkingId)
                    ->where('status','=','1')
                    ->get();

        if($bookingObj->count() > 0) {
            return $bookingObj;
        }
        return [];         
    }
    
    public function calculatePrice($requestData) {
        $bookingObj = DB::table('booking_details')
                    ->join('parkings', 'booking_details.parking_id', '=', 'parkings.id')
                    ->select('booking_details.in_time', 'parkings.cost')
                    ->where('booking_details.parking_id','=',$requestData['partkingId'])
                    ->where('booking_details.slot_id','=',$requestData['slot_id'])
                    ->where('booking_details.status','=','1')
                    ->first();
        return $bookingObj;
    }
    
    public function freeParking($requestData) {
        
        $validatePrice = $this->calculatePrice(['partkingId' => $requestData['parking_id'],
                                                'slot_id' => $requestData['slot_id']]);
        $isModifiedCost = false;
        if(!empty($validatePrice)) {
            $date1 = date_create($validatePrice->in_time);
            $date2 = date_create(date("Y-m-d H:i:s"));
            $diff = date_diff($date1, $date2);
            $hours = $diff->h + ($diff->days * 24);
            if ($hours == 0) {
                $hours = 1;
            }
            $price = $hours * $validatePrice->cost;
            $isModifiedCost = ($price == $requestData['cost']) ? false : true;
        }
        
         $updateDetails = DB::table('booking_details')
            ->where('parking_id', (int) $requestData['parking_id'])
            ->where('slot_id', $requestData['slot_id'])
            ->where('status', 1)
            ->update(['cost' => $requestData['cost'], 'out_time' => date("Y-m-d H:i:s"), 'status' => 2,
                       'payment_mode' => $isModifiedCost]);

        return $updateDetails;
    }
}
