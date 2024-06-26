<?php

namespace Modules\Cms\Services\Public;

use App\Services\BaseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CmsFeedbackService extends BaseService
{
    protected $baseRepository;

    public function __construct(\Modules\Cms\Repositories\CmsFeedbackRepository $cmsStudentFeedbackRepository)
    {
        $this->baseRepository = $cmsStudentFeedbackRepository;
    }

    public function getList(Request $request)
    {
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->baseRepository
            ->where(['is_active'=>true,'is_show_homepage'=>true])
            ->orderBy('sort_order','asc')
            ->limit($this->limit)->get();
        return $collection;
    }
}
