<?php

namespace Modules\Lms\Services\Member;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Exceptions\ApiException;
use Modules\Auth\Models\Teamwork;
use Illuminate\Support\Facades\DB;
use Modules\Lms\Models\Member;
use Modules\Lms\Repositories\ClassRoomRepository;
use Modules\Lms\Repositories\ExamRoomRepository;
use Modules\Lms\Repositories\MemberRepository;

class MemberService extends BaseService
{
    protected $examRoomRepository;
    public function __construct(
        MemberRepository $repository,
        ExamRoomRepository $examRoomRepository,
    )
    {
        $this->baseRepository = $repository;
        $this->examRoomRepository = $examRoomRepository;
    }

    public function getMemberExamRooms($id){
        $dir = request()->query('dir') ?? 'desc';
        $sort = request()->query('sort') ?? 'updated_at';
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->examRoomRepository
            ->whereHas('members', function ($query) use ($id) {
                $query->where('member_id', $id);
            })
            ->orWhereHas('classrooms', function ($query) use ($id){
                $query->whereHas('members',function ($q) use ($id){
                    $q->where('member_id',$id);
                });
            })
            ->orderBy($sort, $dir)
            ->paginate($this->limit);
        return $collection;
    }
}
