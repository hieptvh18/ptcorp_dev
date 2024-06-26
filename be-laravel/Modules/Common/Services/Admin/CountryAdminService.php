<?php

namespace Modules\Common\Services\Admin;

use App\Services\BaseService;
use Modules\Common\Repositories\CountryRepository;

class CountryAdminService extends BaseService {

    public function __construct(CountryRepository $countryRepository) {
        $this->baseRepository = $countryRepository;
    }
}
