<?php

namespace Modules\Cms\Services\Public;

use App\Services\BaseService;

class CmsCategoryService extends BaseService
{
    protected $baseRepository;

    public function __construct(
        \Modules\Cms\Repositories\CmsCategoryRepository $cmsCategoryRepository,
    )
    {
        $this->baseRepository = $cmsCategoryRepository;
    }

    public function getCourseCategories(){
        $dir = request()->query('dir') ?? 'desc';
        $sort = request()->query('sort') ?? 'updated_at';
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->baseRepository
            ->withCount(['courses'])
//            ->where('type','COURSE')
            ->orderBy($sort, $dir)
            ->limit($this->limit);
        return $collection;
    }
}
