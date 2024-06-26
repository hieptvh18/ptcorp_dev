<?php

namespace Modules\Common\Services;

use App\Services\BaseService;
use Modules\Common\Repositories\CategoryRepository;

class CategoryService extends BaseService {

    public function __construct(CategoryRepository $categoryRepository) {
        $this->baseRepository = $categoryRepository;
    }
}
