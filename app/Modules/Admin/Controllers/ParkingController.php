<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\DataTableLib;
use App\Services\RegistrationService;
use Illuminate\Mail\Mailer;
use App\Modules\Admin\Model\Parking;
use App\Modules\Admin\Model\Client;

class ParkingController extends Controller {

    public function __construct(RegistrationService $registrationService, Mailer $mailer) {
        $this->registrationService = $registrationService;
        $this->mailer = $mailer;
    }
    
    public function manageParking() {
        $activeMenuId = array('manageParking');
        return view('Admin::manageParking')->with(['activeMenuId' => $activeMenuId]);
    }
    
    public function getParkingGridAjaxData(Request $request) {
        $dataTableObj = new DataTableLib;
        $parkingObj = new Parking();
        $parkingObj->getGridData($request, $dataTableObj);
    }
    
    public function manageParkingActions(Request $request) {
        
        $action = $request->get('action');
        switch ($action) {
            case 'add':
                return $this->addParking($request);
                break;
            case 'edit':
                return $this->editParking($request);
                break;
            case 'delete':
                return $this->deleteClient($request);
                break;
            case 'view':
                $this->viewUser($request);
                break;
        }        
    }
    
    public function addParking(Request $request) {
        $subAction = $request->get('subAction');
        if ('view' == $subAction) {
            $clientObj = new Client;
            $allClients = $clientObj->getClientList();
            return view('Admin::addParking')->with(['clientList' => $allClients]);
        } else if ('insert' == $subAction) {
            $parkingModel = new Parking();
            $parkingResponse = $parkingModel->insertParking($request);
            if($parkingResponse) {
               flash()->success("Parking added successfully");
            }
            else{
                flash()->success("Something wrong while adding parking");
            }
            return redirect()->intended('/admin/manageParking');
        }        
    }
    
    public function editParking(Request $request) {
        $subAction = $request->get('subAction');
        $parkingId = $request->get('parking_id');
            if ('view' == $subAction) {
                $parkingObj = new Parking();
                $parkingDetails = $parkingObj->getParkingDetails($parkingId);
                $clientObj = new Client;
                $allClients = $clientObj->getClientList();
                if($parkingDetails === false) {
                    flash()->error("Requested parking not found");
                    return redirect()->intended('/admin/manageParking');
                }
                return view('Admin::addParking')->with(['parkingDetails' => $parkingDetails, 'clientList' => $allClients]);
            } else if ('update' == $subAction) {
                $parkingObj = new Parking();
                $response = $parkingObj->updateParkingDetails($request);
                if($response) {
                    flash()->success("Client updated successfully");
                }
                else{
                    flash()->error("Something went wrong");
                }
                return redirect()->intended('/admin/manageParking');
            }        
    }
}
