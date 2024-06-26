<?php

namespace App\Models;


use QCod\Gamify\Gamify;
use Laravel\Sanctum\HasApiTokens;
use Modules\Auth\Traits\HasAuthUser;
use Modules\Quiz\Traits\HasAuthQuiz;
use Overtrue\LaravelLike\Traits\Liker;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Modules\Order\Traits\HasAuthCustomer;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Overtrue\LaravelFavorite\Traits\Favoriter;
use Overtrue\LaravelSubscribe\Traits\Subscriber;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Traits\Plan\CoreHasPlanSubscriptions;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{

    use HasApiTokens, HasFactory, Notifiable, Liker, Favoriter, Subscriber, HasRoles;

    use HasAuthUser, CoreHasPlanSubscriptions, Gamify;

    protected $table = 'auth_users';
    protected $connection = 'mysql';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'username',
        'email',
        'mobile',
        'password',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = ['info'];
}
