<?php

namespace Modules\Common\Services\Admin;

use Illuminate\Http\Request;
use App\Services\BaseService;
use Modules\Common\Repositories\DistrictRepository;

class DistrictAdminService extends BaseService {

    public function __construct(DistrictRepository $provinceRepository) {
        $this->baseRepository = $provinceRepository;
    }

    public function getList(Request $request)
    {
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->baseRepository
            ->with(['country', 'province'])
            ->orderBy($this->sort, $this->dir)
            ->paginate($this->limit);
        return $collection;
    }
}
