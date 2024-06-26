<?php

namespace Modules\Cms\Services\Public;

use App\Services\BaseService;
use Exception;
use Illuminate\Http\Request;

class CmsFaqService extends BaseService
{
    protected $baseRepository;

    public function __construct(\Modules\Cms\Repositories\CmsFaqRepository $cmsFaqRepository)
    {
        $this->baseRepository = $cmsFaqRepository;
    }

    public function getList(Request $request)
    {
        $collection = $this->baseRepository
            ->select('id','faq_category_id','question','answer','is_active','created_at','updated_at')
            ->where('is_active',true)
//            ->orderBy('updated_at','asc')
            ->get();
        return $collection;
    }
}
