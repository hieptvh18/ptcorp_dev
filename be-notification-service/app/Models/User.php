<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;

class User extends \MailCarrier\Models\User
{
    use HasApiTokens;
    protected $table = 'auth_users';
}
