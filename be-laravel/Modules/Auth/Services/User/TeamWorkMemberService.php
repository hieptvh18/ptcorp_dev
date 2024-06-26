<?php

namespace Modules\Auth\Services\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Exceptions\ApiException;
use Mpociot\Teamwork\TeamInvite;
use Modules\Auth\Models\Teamwork;
use Illuminate\Support\Facades\DB;
use Mpociot\Teamwork\Facades\Teamwork as FacadesTeamwork;

class TeamWorkMemberService
{
    public function teamWorkMembers($id, Request $request)
    {
        $limit = request()->query('size') ?? 12;
        $sort = request()->query('sort', 'updated_at');
        $dir = request()->query('dir', 'DESC');
        $team = Teamwork::findOrFail($id);
        $members = $team->users()->orderBy($sort, $dir)
            ->paginate($limit);

        $members = $members->setCollection($members->getCollection()
            ->map(function ($member) use($team){
                if($member->isOwnerOfTeam($team)){
                    $member['is_owner'] = true;
                }else{
                    $member['is_owner'] = false;
                }
                return $member;
            }));
        return $members;
    }

    public function invitedMembers($id, Request $request){
        $limit = request()->query('size') ?? 12;
        $sort = request()->query('sort', 'updated_at');
        $dir = request()->query('dir', 'DESC');
        $invite_members = TeamInvite::where('team_id', $id)->with(['user', 'team'])->orderBy($sort, $dir)
            ->paginate($limit);
        return $invite_members;
    }

    public function findMember($id, $id_member){
        $team = Teamwork::findOrFail($id);
        $member = $team->users()->where('user_id', $id_member)->first();
        return $member;
    }

    public function detachTeamWork($id, $id_member)
    {
        try {
            $team = Teamwork::findOrFail($id);
            $user = auth()->user();
            if($user->isOwnerOfTeam($team) == false){
                throw new ApiException('Bạn không có quyền!!', 401);
            }
            DB::beginTransaction();
            $user_left = User::find($id_member);

            $user_left->detachTeam($team);
            DB::commit();
            return true;
        } catch (ApiException $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
