<?php

namespace Modules\Cms\Services\Admin;

use App\Services\BaseService;
use Modules\Cms\Repositories\CmsBlogTagRepository;

class AdminCmsBlogTagService extends BaseService
{
    protected $baseRepository;

    public function __construct(CmsBlogTagRepository $cmsBlogTagRepository)
    {
        $this->baseRepository = $cmsBlogTagRepository;
    }

}
