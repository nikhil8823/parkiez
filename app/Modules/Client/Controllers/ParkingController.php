<?php

namespace App\Modules\Client\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\RegistrationService;
use Illuminate\Mail\Mailer;
use App\Modules\Client\Model\Parking;
use App\Modules\Client\Model\BookingDetails;
use App\Services\SmsService;

class ParkingController extends Controller {

    public function __construct(RegistrationService $registrationService, Mailer $mailer, SmsService $sms) {
        $this->registrationService = $registrationService;
        $this->mailer = $mailer;
        $this->sms = $sms;
    }

    public function myParkings() {   
        $parkingObj = new Parking();
        $myParkingData = $parkingObj->getMyParkings();
        $activeMenuId = array('myParkings');
        return view('Client::myParking')->with(['activeMenuId' => $activeMenuId, "myParkings" => $myParkingData]);
    }

    public function parkingDetail($parkingId = null) {
        
        $activeMenuId = array('myParkings');
        if (!is_numeric($parkingId) || ($parkingId == null)) {
            flash()->error("Invalid parking id");
            return redirect()->intended('/client/myParkings');
        }
        
        $parkingObj = new Parking();
        $myParkingData = $parkingObj->isMyParking($parkingId);
        
        $bookingObj = new BookingDetails();
        $bookingDetails = $bookingObj->getBookingDetails($parkingId);
        
        if ($myParkingData === false) {
            flash()->error("Invalid parking id");
            return redirect()->intended('/client/myParkings');
        }
        
        return view('Client::parkingDetails')->with(['activeMenuId' => $activeMenuId, 
                    "parkingData" => $myParkingData, 'bookingDetails' => $bookingDetails]);
    }
    
    public function bookingAction(Request $request) {
        
        if ($request->isMethod('post')) {
            $bookingData = $request->all();
            $parkingId = $bookingData['parking_id'];
            $parkingObj = new Parking();
            $myParkingData = $parkingObj->isMyParking($parkingId);
            
            if($bookingData['parking_type'] == "book") {
                 $carNumber = $bookingData['state_name'].'-'.$bookingData['state_code'].'-'.$bookingData['car_series'].'-'.$bookingData['car_number'];
                 $bookParkingObj = new BookingDetails;
                 $bookParkingObj->parking_id = $parkingId;
                 $bookParkingObj->slot_id = $bookingData['slot_id'];
                 //$bookParkingObj->car_number = $bookingData['state_name'].'-'.$bookingData['state_code'].'-'.$bookingData['car_series'].'-'.$bookingData['car_number'];
                 $bookParkingObj->car_number = $carNumber;
                 $bookParkingObj->in_time = date("Y-m-d H:i:s");
                 $bookParkingObj->status = 1;
                 $bookParkingObj->created_at = date("Y-m-d H:i:s");
                 $bookParkingObj->created_at = date("Y-m-d H:i:s");
                 $bookParkingObj->mobile_number = $bookingData['mobile_number'];
                 if($bookParkingObj->save()) {
                     $message= "Welcome to Parkies. You have allotted the Parking slot ".$bookingData['slot_id']." at ".$myParkingData->title." on ".date("Y-m-d H:i:s").". Your car number is ".
                             $carNumber;
                     $smsResponse = $this->sms->sendSms($bookingData['mobile_number'], $message);
                     $bookParkingObj = new BookingDetails;
                     $updateParking = $bookParkingObj->updateSmsStatus($bookingData, $smsResponse, "booking");
                     flash()->success("Parking book successfully");
                 }
                 else{
                     flash()->error("Something went wrong while booking the parking");
                 }
            }
            else if($bookingData['parking_type'] == "free") {
                $carNumber = $bookingData['state_name'].'-'.$bookingData['state_code'].'-'.$bookingData['car_series'].'-'.$bookingData['car_number'];
                $bookParkingObj = new BookingDetails;
                $updateParking = $bookParkingObj->freeParking($bookingData);
                if($updateParking == 1) {
                    $message= "Your allotted parking slot ".$bookingData['slot_id']." at ".$myParkingData->title." has released on ".date("Y-m-d H:i:s").". Your car number is ".
                             $carNumber;
                     $smsResponse = $this->sms->sendSms($bookingData['mobile_number'], $message);
                     $bookParkingObj = new BookingDetails;
                     $updateParking = $bookParkingObj->updateSmsStatus($bookingData, $smsResponse, "free");
                    flash()->success("Slot is free! Thanks for payment of Rs. ". $bookingData['cost']);
                }
                else{
                    flash()->error("something went wrong. contact to support team.");
                }
            }
            else{
                flash()->error("Something went wrong");
            }
            return redirect()->intended("/client/parkingDetail/$parkingId");
        }
    }
    
    public function calculatePrice(Request $request) {
        
        if ($request->isMethod('post')) {
            $requestData = $request->all();
            $bookParkingObj = new BookingDetails;
            $costData = $bookParkingObj->calculatePrice($requestData);
            if(!empty($costData)) {
                $date1 = date_create($costData->in_time);
                $date2 = date_create(date("Y-m-d H:i:s"));
                $diff = date_diff($date1, $date2);
                $hours = $diff->h + ($diff->days * 24);
                if ($hours == 0) {
                    $hours = 1;
                }
                $price = $hours * $costData->cost;
                echo $data = json_encode(Array('flag' => "true", 'cost' => $price));
            }
            else{
                echo $data = json_encode(Array('flag' => "false", 'cost' => ''));
            }
        }
    }

}
