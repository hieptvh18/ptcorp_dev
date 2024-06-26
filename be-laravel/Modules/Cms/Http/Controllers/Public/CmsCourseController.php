<?php

namespace Modules\Cms\Http\Controllers\Public;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Cms\Http\Requests\Public\CmsCoursePublishRequest;
use Modules\Cms\Models\Course;

/**
 * @group Module Cms
 *
 * APIs public for course
 *
 * @subgroup Cms Course
 * @subgroupDescription CmsCourseController
 */
class CmsCourseController extends ApiController
{
    protected $courseService;

    public function __construct(\Modules\Cms\Services\Public\CmsCourseService $courseService)
    {
        $this->middleware(['workspace_db']);
        $this->courseService = $courseService;
    }

    /**
     * Danh sách khóa học đang bán
     * @return Response
     */
    public function index(CmsCoursePublishRequest $request)
    {
        $courses = $this->courseService->getCoursesPublish($request);
        return $this->json($courses);
    }

    /**
     * Lấy meta data khóa học
     * @param int $id
     * @return Response
     */
    public function getMetaCourse($alias)
    {
        $data = Course::where('alias', $alias)->firstOrFail();
        return $this->json(['data' => $data]);
    }

    /**
     * Lấy chi tiết khóa học
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $courses = $this->courseService->getCourse($id);
        return $this->json($courses);
    }

    /**
     * Api danh sách cho phép filter
     * @return Response
     */
    public function getFilterable(Request $request)
    {
        $courses = $this->courseService->getListFilterable($request);
        return $this->json($courses);
    }

    /**
     * Api danh sách khóa học liên quan
     * @return Response
     * @param $course_id
     */
    public function getRecommendCourses($course_id)
    {
        $courses = $this->courseService->getRecommendCourses($course_id);
        return $this->json($courses);
    }
}
