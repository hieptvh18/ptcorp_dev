<?php

namespace Modules\Notification\Services\Admin;

use Illuminate\Http\Request;
use App\Services\BaseService;
use Modules\Notification\Repositories\EmailTemplateRepository;

class EmailTemplateAdminService extends BaseService
{

    public function __construct(EmailTemplateRepository $emailTemplateRepository)
    {
        $this->baseRepository = $emailTemplateRepository;
    }

}
