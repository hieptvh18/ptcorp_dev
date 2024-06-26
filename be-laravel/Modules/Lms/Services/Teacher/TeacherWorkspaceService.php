<?php

namespace Modules\Lms\Services\Teacher;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Modules\Lms\Models\LmsRole;
use Modules\Auth\Repositories\WorkspaceInfoRepository;

class TeacherWorkspaceService extends BaseService
{
    public function __construct(WorkspaceInfoRepository $repository)
    {
        $this->baseRepository = $repository;
    }

    public function lmsGetRole(Request $request)
    {
        $withCountMember = request()->query('has_count_member');
        $data = LmsRole::orderBy($this->sort, $this->dir);
        if($withCountMember == 1){
            $data = $data->withCount('members');
        }
        return $data->paginate($this->limit);
    }
}
