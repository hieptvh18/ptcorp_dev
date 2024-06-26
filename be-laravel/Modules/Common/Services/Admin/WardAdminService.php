<?php

namespace Modules\Common\Services\Admin;

use Illuminate\Http\Request;
use App\Services\BaseService;
use Modules\Common\Repositories\WardRepository;

class WardAdminService extends BaseService {

    public function __construct(WardRepository $wardRepository) {
        $this->baseRepository = $wardRepository;
    }

    public function getList(Request $request)
    {
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->baseRepository
            ->with(['country', 'province', 'district'])
            ->orderBy($this->sort, $this->dir)
            ->paginate($this->limit);
        return $collection;
    }
}
