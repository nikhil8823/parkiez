<?php

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;

class DashboardController extends Controller {

    public function __construct() {
        
    }

    public function getDashboard() {
        $activeMenuId = array('dashboard');
        return view('Admin::manageDashboard')->with(['activeMenuId' => $activeMenuId]);
    }

    public function getDetails(Request $request) {
        $type = $request->get('type');
        $userCount = $this->getBusinessDetails($type);
        $quotesCount = $this->getQuotesCount($type);
        $shipmentRequestCount = $this->getShipmentCount($type);
        $businessCount = $this->getTotalBusiness($type);foreach($businessCount as $key =>$val){
            $totalBusiness = null == $val->total?0:$val->total;
        }
        $detailsArray = ['userCount' => $userCount, 'quotesCount' => $quotesCount, 'shipmentCount' => $shipmentRequestCount,'businessCount'=>$totalBusiness];
        echo json_encode($detailsArray);
    }

    public function getBusinessDetails($type) {
        $userObj = new UserModel();
        $userCount = $userObj->getRegisteredUserCount($type);
        return $userCount;
    }

    public function getShipmentCount($type) {
        $userObj = new Shipment();
        $userCount = $userObj->getShipmentCount($type);
        return $userCount;
    }

    public function getQuotesCount($type) {
        $userObj = new Bid();
        $userCount = $userObj->getQuotesCount($type);
        return $userCount;
    }
    
    public function getTotalBusiness($type) {
        $shipmentAwdObj = new ShipmentAwarded();
        $totalBusiness = $shipmentAwdObj->getTotalBusiness($type);
        return $totalBusiness;
    }

}