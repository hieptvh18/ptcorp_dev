<?php

namespace Modules\Lms\Services\Admin;

use App\Services\BaseService;
use Modules\Lms\Repositories\SchoolYearRepository;

class AdminSchoolYearService extends BaseService
{
    public function __construct(SchoolYearRepository $repository)
    {
        $this->baseRepository = $repository;
    }
}
