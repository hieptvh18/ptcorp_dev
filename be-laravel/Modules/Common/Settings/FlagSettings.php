<?php

namespace Modules\Common\Settings;

use Spatie\LaravelSettings\Settings;

class FlagSettings extends Settings
{

    public array $flag;

    public static function group(): string
    {
        return 'flag';
    }
}
