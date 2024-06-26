<?php

namespace Modules\Cms\Services\Admin;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Auth\Events\EventWorkspaceInfoServiceCreateAfter;

class AdminCourseScheduleService extends BaseService
{
    protected $baseRepository;

    public function __construct(\Modules\Cms\Repositories\CourseScheduleRepository $cmsCourseScheduleRepository)
    {
        $this->baseRepository = $cmsCourseScheduleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function findScheduleByCourseId($courseId)
    {
        $dir = request()->query('dir') ?? 'desc';
        $sort = request()->query('sort') ?? 'updated_at';
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->baseRepository
            ->where(['course_id'=>$courseId,'is_active'=>true])
            ->orderBy($sort, $dir)
            ->paginate($this->limit);
        return $collection;
    }
}
