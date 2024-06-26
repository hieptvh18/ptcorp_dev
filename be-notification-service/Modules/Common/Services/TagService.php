<?php

namespace Modules\Common\Services;

use App\Services\BaseService;
use Modules\Common\Repositories\TagRepository;

class TagService extends BaseService {

    public function __construct(TagRepository $tagRepository) {
        $this->baseRepository = $tagRepository;
    }
}
