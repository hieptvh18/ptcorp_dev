<?php

namespace Modules\Auth\Services\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Modules\Auth\Repositories\WorkspaceInfoRepository;

class AdminWorkspaceInfoService extends BaseService
{
    public function __construct(WorkspaceInfoRepository $repository)
    {
        $this->baseRepository = $repository;
    }

    public function getList(Request $request)
    {
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->baseRepository->with('creator')
            ->orderBy($this->sort, $this->dir)
            ->paginate($this->limit);
        return $collection;
    }

}
