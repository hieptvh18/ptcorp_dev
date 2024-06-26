<?php

namespace Modules\Lms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\CoreHasAlias;
use Modules\Core\Traits\CoreHasUniqueCode;
use Modules\Core\Traits\CoreHasUserAudit;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class SchoolLevel.
 *
 * @package namespace Modules\Lms\Models;
 */
class QuizSchoolLevel extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "quiz_level_schools";

}
