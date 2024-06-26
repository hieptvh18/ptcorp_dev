<?php

namespace Modules\Cms\Services\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\BaseService;

class AdminFaqService extends BaseService
{
    protected $baseRepository;

    public function __construct(\Modules\Cms\Repositories\CmsFaqRepository $cmsFaqRepository)
    {
        $this->baseRepository = $cmsFaqRepository;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function getList(Request $request)
    {
        $dir = request()->query('dir') ?? 'desc';
        $sort = request()->query('sort') ?? 'updated_at';
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->baseRepository
            ->with(['faqCategory'=>function($q){
                $q->select(['id','name','description','image_url']);
            }])
            ->orderBy($sort, $dir)
            ->paginate($this->limit);
        return $collection;
    }

    public function find($id)
    {
        $model = $this->baseRepository
            ->with(['faqCategory'=>function($q){
                $q->select(['id','name','description','image_url']);
            }])
            ->findWhere(['id'=>$id])->first();

        return $model;
    }
}
