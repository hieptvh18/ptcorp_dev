<?php

namespace Modules\Cms\Services\Admin;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Auth\Events\EventWorkspaceInfoServiceCreateAfter;

class AdminCourseLanguageService extends BaseService
{
    protected $baseRepository;

    public function __construct(\Modules\Cms\Repositories\CourseLanguageRepository $cmsBannerRepository)
    {
        $this->baseRepository = $cmsBannerRepository;
    }
}
