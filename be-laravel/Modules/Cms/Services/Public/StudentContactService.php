<?php

namespace Modules\Cms\Services\Public;

use App\Services\BaseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Cms\Events\ClientSendContactAfter;

class StudentContactService extends BaseService
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
            $workspaceAlias = $request->header('workspace');
            event(new ClientSendContactAfter($item,$workspaceAlias));
            return $item;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
