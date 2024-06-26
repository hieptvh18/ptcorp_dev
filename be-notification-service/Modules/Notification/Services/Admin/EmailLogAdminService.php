<?php

namespace Modules\Notification\Services\Admin;

use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Carbon;
use Modules\Notification\Repositories\EmailLogRepository;

class EmailLogAdminService extends BaseService
{

    public function __construct(EmailLogRepository $emailLogRepository)
    {
        $this->baseRepository = $emailLogRepository;
    }

    public function getList(Request $request)
    {
        $this->limit = request()->query('size') ?? 12;
        $created_at = request()->query('created_at');
        $collection = $this->baseRepository
            ->with('template:id,name')
            ->orderBy($this->sort, $this->dir);

        if ($created_at) {
            $created_at = Carbon::parse($created_at);
            $collection = $collection->whereDate('created_at', $created_at);
        }

        $collection = $collection->paginate($this->limit);
        return $collection;
    }
}
