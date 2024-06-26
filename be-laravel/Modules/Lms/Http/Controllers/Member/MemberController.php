<?php

namespace Modules\Lms\Http\Controllers\Member;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\ApiController;
use Modules\Lms\Services\Member\MemberService;

/**
 * @group Module Lms
 *
 * APIs for member
 *
 * @subgroup member
 * @subgroupDescription MemberController
 */
class MemberController extends ApiController
{
    protected $memberService;

    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }

    /**
     * Member xem danh sách phòng thi
     *
     * @param Request $request
     * @return Response
     */
    public function getMemberExamRooms($memberId)
    {
        $data = $this->memberService->getMemberExamRooms($memberId);
        return $this->json($data);
    }
}
