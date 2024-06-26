<?php

namespace Modules\Auth\Models;

use Modules\Lms\Models\QuizSchoolLevel;
use Mpociot\Teamwork\TeamworkTeam;
use Modules\Quiz\Models\LevelSchool;

class Teamwork extends TeamworkTeam
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'owner_id', 'teamable_id', 'teamable_type'];

    public function teamable()
    {
        return $this->morphTo('teamable');
    }

    public function quizSchoolLevels()
    {
        return $this->belongsToMany(QuizSchoolLevel::class, 'auth_workspace_level_school', 'teamwork_id', 'level_school_id');
    }
}
