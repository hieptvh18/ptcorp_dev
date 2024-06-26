<?php

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Spatie\LaravelSettings\Models\SettingsProperty;

/**
 * Class Setting.
 *
 * @package namespace Modules\Cms\Models;
 */
class Setting extends SettingsProperty implements Transformable
{
    use TransformableTrait;

    protected $casts = [
        'payload' => 'json',
    ];

}
