<?php

namespace Modules\Auth\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Modules\Auth\Services\User\TeamWorkService;

/**
 * @group Module Auth
 *
 * APIs for managing teamWorks
 *
 * @subgroup User Team Work
 * @subgroupDescription TeamWorkController
 */
class TeamWorkController extends ApiController
{
    protected $teamWorkService;

    public function __construct(TeamWorkService $teamWorkService)
    {
        $this->teamWorkService = $teamWorkService;
    }

    /**
     * invite team
     *
     * Mời vào nhóm
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function inviteTeamWork($id, Request $request)
    {

        $this->teamWorkService->inviteTeamWork($id, $request);

        return response()->json(['success' => true], 200);
    }

    /**
     * accept team
     *
     * chấp nhận vào nhóm
     * @param string $token
     * @param int $id
     * @return void
     */
    public function acceptInvite($id, $token)
    {

        $this->teamWorkService->acceptInvite($id, $token);

        return response()->json(['success' => true]);
    }

    /**
     * deny team
     *
     * Từ chối vào nhóm
     * @param string $token
     * @param int $id
     * @return void
     */
    public function denyInvite($id, $token)
    {

        $this->teamWorkService->denyInvite($id, $token);

        return response()->json(['success' => true]);
    }

    /**
     * my invited
     *
     * Danh sách lời mới vào nhóm của tôi
     * @param Request $request
     * @return void
     */
    public function myInvited(Request $request)
    {
        $data = $this->teamWorkService->myInvited($request);

        return response()->json($data);
    }

    /**
     * joined teamwork
     *
     * Danh sách teamwork tôi đã tham gia
     * @param Request $request
     * @return void
     */
    public function joinedTeamWorks(Request $request)
    {
        $data = $this->teamWorkService->joinedTeamWorks($request);

        return response()->json($data);
    }

    /**
     * cancel invitation
     *
     * Hủy bỏ lời mời vào tổ chức
     * @param int $id_invite
     * @param int $id
     * @return void
     */
    public function cancelInvitation($id, $id_invite)
    {
        $data = $this->teamWorkService->cancelInvitation($id, $id_invite);

        return response()->json(['success' => $data]);
    }
}
