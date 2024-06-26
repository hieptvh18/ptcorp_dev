<?php

namespace Modules\Cms\Http\Controllers\Public;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Cms\Http\Requests\Public\CmsCoursePublishRequest;

/**
 * @group Module Cms
 *
 * APIs public for course category
 *
 * @subgroup Cms Category
 * @subgroupDescription CmsCategoryController
 */
class CmsCategoryController extends ApiController
{
    protected $categoryService;

    public function __construct(\Modules\Cms\Services\Public\CmsCategoryService $categoryService)
    {
        $this->middleware(['workspace_db']);
        $this->categoryService = $categoryService;
    }

    /**
     * Danh sách danh mục khóa học
     * @return Response
     */
    public function index()
    {
        $courses = $this->categoryService->getCourseCategories();
        return $this->json($courses);
    }
}
