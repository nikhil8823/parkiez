<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\MailResetPasswordToken;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable {

    use Notifiable;

    protected $guard = 'admin';
    protected $table = 'admin_users';
    public $timestamps = false;
    protected $fillable = [
        'email', 'password', 'name', 'created_at', 'updated_at'
    ];

    public function roles() {
        $adminData = \Illuminate\Support\Facades\DB::table('admin_users')
                        ->select('name', 'email')->where('email', $this->email)->first();
        return $adminData;
    }

}
