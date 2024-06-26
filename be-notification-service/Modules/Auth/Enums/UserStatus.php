<?php

namespace Modules\Auth\Enums;

enum UserStatus: string
{
    case VERIFIED = 'VERIFIED';
    case NOT_VERIFY = 'NOT_VERIFY';
    case BLOCKED = 'BLOCKED';
}
