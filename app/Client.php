<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\MailResetPasswordToken;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable {

    use Notifiable;

    protected $guard = 'client';
    protected $table = 'clients';
    public $timestamps = false;
    protected $fillable = [
       'id', 'email', 'password', 'name', 'created_at', 'updated_at'
    ];

    public function roles() {
        $clientData = \Illuminate\Support\Facades\DB::table('clients')
                        ->select('name', 'email')->where('email', $this->email)->first();
        return $clientData;
    }

}
