<?php
namespace App\Services;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;

class RegistrationService {

    protected $mailer, $notify;

    public function __construct(Mailer $mailer) {
        $this->mailer = $mailer;
    }

    public function sendRegisterMail($user, $password, $link) {
        try {
            $data = ['name' => isset($user->first_name)?$user->first_name:$user['contactPersonName'], 'email' => isset($user->email)?$user->email:$user['email'], 'password' => $password, 'link' => $link];
            $this->mailer->send('emails.welcomeCustomer', $data, function (Message $m) use ($user) {
                $m->to(isset($user->email)?$user->email:$user['email'])->subject("Welcome to Cargo shipment");
            });
        } catch (\Exception $ex) {
            echo $ex;
            die;
        }
    }
  
    public function sendWelcomeMail($user, $link) {
        try {
            $data = ['email' => isset($user->email)?$user->email:$user['email'],'link' => $link, 'password'=>isset($user->password)?$user->password:$user['password']];
            $this->mailer->send('emails.registerClient', $data, function (Message $m) use ($user) {
                $m->to(isset($user->email)?$user->email:$user['email'])->subject("Welcome to Parkiez");
            });
        } catch (\Exception $ex) {
            echo $ex;
            die;
        }
    }
}