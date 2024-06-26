<?php

namespace Modules\Common\Services\Admin;

use Illuminate\Http\Request;
use App\Services\BaseService;
use Modules\Common\Repositories\ProvinceRepository;

class ProvinceAdminService extends BaseService {

    public function __construct(ProvinceRepository $provinceRepository) {
        $this->baseRepository = $provinceRepository;
    }

    public function getList(Request $request)
    {
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->baseRepository
            ->with('country')
            ->orderBy($this->sort, $this->dir)
            ->paginate($this->limit);
        return $collection;
    }
}
