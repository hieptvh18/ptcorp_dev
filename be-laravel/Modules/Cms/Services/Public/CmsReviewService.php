<?php

namespace Modules\Cms\Services\Public;

use App\Services\BaseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Cms\Models\Course;
use Modules\Cms\Models\CourseReview;

class CmsReviewService extends BaseService
{
    protected $baseRepository;
    protected $courseRepository;

    public function __construct(
        \Modules\Cms\Repositories\CmsReviewRepository $cmsReviewRepository,
        \Modules\Cms\Repositories\CourseRepository $courseRepository,
    ) {
        $this->baseRepository = $cmsReviewRepository;
        $this->courseRepository = $courseRepository;
    }

    public function getCourseReview(Request $request, $courseId)
    {
        $course = $this->courseRepository->findOrFail($courseId);
        $dir = request()->query('dir') ?? 'desc';
        $sort = request()->query('sort') ?? 'updated_at';
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->baseRepository
            ->with(['authorReview' => function ($q) {
                $q->select('id', 'username', 'email', 'mobile');
            }])
            ->whereHasMorph('reviewrateable', Course::class)
            ->where([
                // 'approved'=>true,
                'reviewrateable_id' => $courseId
            ])
            ->orderBy($sort, $dir)
            ->limit($this->limit)
            ->get();
        return $collection;
    }
}
