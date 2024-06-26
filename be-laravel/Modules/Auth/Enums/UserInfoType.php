<?php

namespace Modules\Auth\Enums;

enum UserInfoType: string
{
    case STUDENT = 'STUDENT';
    case TEACHER = 'TEACHER';
    case ADMIN = 'ADMIN';
    case SV_HUBT = 'SV_HUBT';
    case OTHER = 'OTHER';
}
