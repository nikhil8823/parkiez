<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\DataTableLib;
use App\Services\RegistrationService;
use Illuminate\Mail\Mailer;
use File;
use Session;
use App\Modules\Admin\Model\Client;

class ClientController extends Controller {

    public function __construct(RegistrationService $registrationService, Mailer $mailer) {
        $this->registrationService = $registrationService;
        $this->mailer = $mailer;
    }
    
    public function clientView() {
        $activeMenuId = array('manageClient');
        return view('Admin::manageClient')->with(['activeMenuId' => $activeMenuId]);
    }

    public function getClientGridAjaxData(Request $request) {
        $dataTableObj = new DataTableLib;
        $userObj = new Client();
        $userObj->getGridData($request, $dataTableObj);
    }

    public function manageClientActions(Request $request)
    {
        $action = $request->get('action');
        
        switch ($action) {
            case 'add':
                return $this->addClient($request);
                break;
            case 'edit':
                return $this->editClient($request);
                break;
            case 'delete':
                return $this->deleteClient($request);
                break;
            case 'view':
                $this->viewUser($request);
                break;
        }
    }
    
    public function addClient(Request $request) {

        $subAction = $request->get('subAction');
        if ('view' == $subAction) {
            return view('Admin::addClient');
        } else if ('insert' == $subAction) {
            $clientModel = new Client();
            $getDetails = $clientModel->insertClient($request);
            $url = str_replace('/admin/manageClientActions', '', url()->current());
            $activationLink = $url;
            $this->registrationService->sendWelcomeMail($getDetails, $activationLink);
            flash()->success("Client added successfully");
            return redirect()->intended('/admin/manageClient');
        }
    }
    
    public function editClient(Request $request)
    {
        $subAction = $request->get('subAction');
        $clientId = $request->get('client_id');

            if ('view' == $subAction) {
                $client = new Client();
                $clientDetails = $client->getClient($clientId);
                return view('Admin::addClient')->with(['clientDetails' => $clientDetails]);
            } else if ('update' == $subAction) {
                $client = new Client();
                $response = $client->updateClient($request);
                if($response) {
                    flash()->success("Client updated successfully");
                }
                else{
                    flash()->error("Something went wrong");
                }
                return redirect()->intended('/admin/manageClient');
            }
    }
    
    public function deleteClient(Request $request)
    {
        $clientObj = new Client();
        $clientObj->deActivateClient($request);
        return redirect()->intended('/admin/manageClient');
    }    
}
