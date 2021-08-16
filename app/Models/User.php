<?php

namespace App\Models;

use App\Models\Info\UserAttr;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        UserAttr::FULLNAME,
        UserAttr::EMAIL,
        UserAttr::PASSWORD,
        UserAttr::USER_TYPE,
        UserAttr::IS_ACTIVATED,
        UserAttr::PASSWORD_RESET_CODE,
        UserAttr::ACTIVATION_CODE,
        UserAttr::SOCIAL_TYPE,
        UserAttr::IS_ACTIVE,
    ];

    protected $hidden = [
        UserAttr::PASSWORD,
    ];

    protected $casts = [
        UserAttr::IS_ACTIVATED => 'boolean',
        UserAttr::IS_ACTIVE => 'boolean',
    ];
}
