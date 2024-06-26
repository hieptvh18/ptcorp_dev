<?php

namespace Modules\Cms\Services\Public;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Modules\Cms\Repositories\CmsBlogTagRepository;

class CmsBlogTagService extends BaseService
{

    public function __construct(CmsBlogTagRepository $cmsBlogTagRepository)
    {
        $this->baseRepository = $cmsBlogTagRepository;
    }

    public function getListTagAssignBlog(Request $request)
    {
        $collection = $this->baseRepository->has('blogs')
            ->orderBy($this->sort, $this->dir)
            ->paginate($this->limit);
        return $collection;
    }

}
