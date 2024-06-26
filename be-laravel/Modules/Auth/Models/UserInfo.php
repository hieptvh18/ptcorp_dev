<?php

namespace Modules\Auth\Models;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserInfo extends Model
{
    protected $table = 'auth_user_info';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'birthday',
        'gender',
        'avatar_url',
        'type',
        'custom_data',
        'extra'
    ];

    protected $casts = [
        'custom_data' => 'json'
    ];

}
