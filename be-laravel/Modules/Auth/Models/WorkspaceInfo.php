<?php

namespace Modules\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Traits\HasTeamwork;
use Modules\Core\Traits\CoreHasUniqueCode;
use Modules\Core\Traits\CoreHasUserAudit;
use Modules\Lms\Models\QuizSchoolLevel;
use Modules\Lms\Traits\LmsSwitchDatabase;
use Modules\Lms\Models\SchoolLevel;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class WorkspaceInfo.
 *
 * @package namespace Modules\Auth\Models;
 */
class WorkspaceInfo extends Model implements Transformable
{
    use TransformableTrait, HasTeamwork, CoreHasUniqueCode, CoreHasUserAudit, LmsSwitchDatabase;

    protected $table = "auth_workspace_info";
    protected $connection = "mysql";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'teamwork_id',
        'name',
        'short_name',
        'code',
        'alias',
        'email',
        'description',
        'avatar_url',
        'background_image_url',
        'mobile',
        'address',
        'website',
        'founded_date',
        'custom_data'
    ];

    protected $casts = ['custom_data' => 'json'];

    protected $with = ['team'];

    public function team()
    {
        return $this->belongsTo(Teamwork::class, 'teamwork_id');
    }
}
