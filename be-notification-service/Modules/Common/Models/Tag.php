<?php

namespace Modules\Common\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Exam.
 *
 * @package namespace Modules\Common\Models;
 */
class Tag extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'common_tags';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','description','module', 'user_id'];

}
