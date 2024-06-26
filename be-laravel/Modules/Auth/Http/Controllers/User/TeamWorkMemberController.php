<?php

namespace Modules\Auth\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Modules\Auth\Services\User\TeamWorkMemberService;

/**
 * @group Module Auth
 *
 * APIs for managing teamWorkMembers
 *
 * @subgroup User Team Work Member
 * @subgroupDescription TeamWorkMemberController
 */
class TeamWorkMemberController extends ApiController
{
    protected $teamWorkMemberService;

    public function __construct(TeamWorkMemberService $teamWorkMemberService)
    {
        $this->teamWorkMemberService = $teamWorkMemberService;
    }

    /**
     * List members of team
     *
     * Danh sách thành viên
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function teamWorkMembers($id, Request $request)
    {
        $data = $this->teamWorkMemberService->teamWorkMembers($id, $request);

        return response()->json($data);
    }

    /**
     * list invited members
     *
     * Danh sách thành viên đang được mời
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function invitedMembers($id, Request $request)
    {
        $data = $this->teamWorkMemberService->invitedMembers($id, $request);

        return response()->json($data);
    }

    /**
     * find member
     *
     * chi tiết thành viên trong nhóm
     * @param int $id_member
     * @param int $id
     * @return void
     */
    public function findMember($id, $id_member)
    {
        $data = $this->teamWorkMemberService->findMember($id, $id_member);

        return response()->json(['data' => $data]);
    }

    /**
     * detach user
     *
     * Xóa user khỏi nhóm
     * @param Request $request
     * @return void
     */
    public function detachTeamWork($id, $id_member)
    {
        $this->teamWorkMemberService->detachTeamWork($id, $id_member);

        return response()->json(['success' => true]);
    }
}
