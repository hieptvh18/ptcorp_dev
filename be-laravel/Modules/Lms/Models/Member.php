<?php

namespace Modules\Lms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Auth\Models\Role;
use Modules\Core\Traits\CoreHasUserAudit;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Member.
 *
 * @package namespace Modules\Lms\Models;
 */
class Member extends Model implements Transformable
{
    use TransformableTrait, CoreHasUserAudit, SoftDeletes;

    protected $table = "lms_members";
    protected $connection = 'workspace_db';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'firstname',
        'lastname',
        'birth_date',
        'mobile',
        'email',
        'type',
        'avatar_url',
        'custom_data'
    ];

    protected $casts = ['custom_data' => 'json'];

    public function roles()
    {
        return $this->belongsToMany(LmsRole::class, 'lms_member_role_map', 'member_id', 'role_id');
    }

    public function classrooms()
    {
        return $this->belongsToMany(ClassRoom::class, 'lms_member_classroom', 'member_id', 'classroom_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'lms_teacher_subject', 'teacher_id', 'subject_id');
    }

    public function schoolYears()
    {
        return $this->belongsToMany(SchoolYear::class, 'lms_member_school_year_map', 'member_id', 'school_year_id');
    }

    public function examRooms()
    {
        return $this->belongsToMany(ExamRoom::class, 'lms_member_exam_room_map', 'member_id', 'exam_room_id');
    }
}
