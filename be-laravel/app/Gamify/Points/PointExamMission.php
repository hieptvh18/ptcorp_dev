<?php

namespace App\Gamify\Points;

use Illuminate\Support\Facades\Log;
use Modules\Quiz\Models\Exam;
use QCod\Gamify\PointType;

class PointExamMission extends PointType
{
    /**
     * Number of points
     *
     * @var int
     */
    public $points = 0;

    protected $subject;
    /**
     * Point constructor
     *
     * @param $subject
     */
    public function __construct(Exam $exam, $points)
    {
        $this->subject = $exam;
        $this->points = $points;
    }

    /**
     * User who will be receive points
     *
     * @return mixed
     */
    public function payee()
    {
        $user = $this->getSubject()->creator;
        return $user;
    }
}
