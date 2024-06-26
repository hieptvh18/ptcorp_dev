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
 * Class ExamRoom.
 *
 * @package namespace Modules\Lms\Models;
 */
class ExamRoom extends Model implements Transformable
{
    use TransformableTrait,CoreHasUserAudit, SoftDeletes, CoreHasAlias, CoreHasUniqueCode;

    protected $table = "lms_exam_rooms";

    protected $connection = 'workspace_db';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'alias',
        'code',
        'description',
        'subject_id',
        'exam_type',
        'exam_id',
        'start_date',
        'end_date',
        'is_active'
    ];

    protected $casts = ['is_active'=>'boolean'];

    public function classrooms(){
        return $this->belongsToMany(ClassRoom::class,'lms_class_exam_room_map','exam_room_id','class_id');
    }

    public function members(){
        return $this->belongsToMany(Member::class,'lms_member_exam_room_map','exam_room_id','member_id');
    }
}
