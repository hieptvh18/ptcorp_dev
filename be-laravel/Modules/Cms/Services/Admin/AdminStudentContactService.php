<?php

namespace Modules\Cms\Services\Admin;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Auth\Events\EventWorkspaceInfoServiceCreateAfter;

class AdminStudentContactService extends BaseService
{
    protected $baseRepository;

    public function __construct(\Modules\Cms\Repositories\CmsStudentContactRepository $cmsStudentContactRepository)
    {
        $this->baseRepository = $cmsStudentContactRepository;
    }

    /**
     *
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function create(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $data['ip_address'] = $request->ip();
            $data['user_agent'] = $request->userAgent();
            $item = $this->baseRepository->create($data);
            DB::commit();
            return $item;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
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
            ->orderBy($sort, $dir)
            ->paginate($this->limit);
        return $collection;
    }
}
