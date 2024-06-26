<?php

namespace Modules\Lms\Services\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Modules\Lms\Models\LmsRole;
use App\Exceptions\ApiException;
use Modules\Auth\Models\Teamwork;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Repositories\WorkspaceInfoRepository;
use Modules\Lms\Models\Member;
use Mpociot\Teamwork\Exceptions\UserNotInTeamException;

class UserWorkspaceService extends BaseService
{
    public function __construct(WorkspaceInfoRepository $repository)
    {
        $this->baseRepository = $repository;
    }

    public function getCurrentWorkspace(Request $request)
    {
        $user = auth()->user();
        $team = $user->currentTeam;
        if ($team) {
            $current_workspace = $team->teamable;
            $current_workspace['count_members'] = count($team->users);
        } else {
            $current_workspace = [];
        }

        return $current_workspace;
    }

    public function teamWorkMembers($id, Request $request)
    {
        $limit = request()->query('size') ?? 12;
        $sort = request()->query('sort', 'updated_at');
        $dir = request()->query('dir', 'DESC');
        $team = Teamwork::findOrFail($id);
        $user_ids = $team->users()->pluck('id');
        $workspace = $team->teamable;
        $workspace->setConfigDatabase($workspace->alias);
        $members = Member::whereIn('user_id', $user_ids)->with('roles')
            ->orderBy($sort, $dir)
            ->paginate($limit);
        return $members;
    }

    public function getWorkspaceInfo($id, Request $request){
        $team = Teamwork::find($id);
        $workspace = $team->teamable->load('team.quizSchoolLevels');
        return $workspace;
    }

    public function myRole($id, Request $request){
        $user = auth()->user();
        $team = Teamwork::find($id);
        $workspace = $team->teamable;
        $workspace->setConfigDatabase($workspace->alias);
        $member = Member::where('user_id', $user->id)->first();
        $roles = $member->roles;
        return $roles;
    }
}
