<?php

namespace Modules\Auth\Traits;

use Modules\Quiz\Models\Exam;
use Modules\Auth\Models\UserInfo;
use Modules\Auth\Enums\UserStatus;
use Modules\Quiz\Models\InfoGroup;
use Modules\Quiz\Models\ExamChanel;
use Modules\Auth\Enums\UserInfoType;
use Modules\Core\Models\UserMission;
use Illuminate\Support\Facades\Cache;
use Modules\Quiz\Models\UserInfoQuiz;
use Modules\Auth\Notifications\VerifyEmail;
use NextApps\VerificationCode\VerificationCode;
use Mpociot\Teamwork\Traits\UserHasTeams;

trait HasAuthUser
{

    use UserHasTeams;
    /**
     * Listen for events on model and capture the
     * appropriate activities.
     *
     * @return void
     */
    protected static function bootHasAuthUser()
    {
        // Register Models Event
        static::deleted(function ($user) {
            // before delete() method call this
            $user->info()->delete();
        });
    }

    public function info()
    {
        return $this->hasOne(UserInfo::class, 'user_id');
    }

    public function chanel()
    {
        return $this->hasOne(ExamChanel::class, 'user_id');
    }

    public function user_missions()
    {
        return $this->hasMany(UserMission::class, 'user_id');
    }

    public function infoGroups()
    {
        return $this->belongsToMany(InfoGroup::class, 'quiz_exam_user_group_map', 'user_id', 'info_group_id');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class, 'created_by');
    }

    /**
     * Mark the given user's email as verified.
     *
     * @return bool
     */
    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
            'status' => 'VERIFIED'
        ])->save();
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        VerificationCode::send($this->getEmailForVerification());
        // $this->notify(new VerifyEmail);
    }

    public function verifyCode($code)
    {
        return VerificationCode::verify($code, $this->getEmailForVerification(), true);
    }

    public function block()
    {
        return $this->forceFill([
            'status' => 'BLOCKED'
        ])->save();
    }

    public function isAdminCrm()
    {
        return $this->info->type === 'ADMIN';
    }
}
