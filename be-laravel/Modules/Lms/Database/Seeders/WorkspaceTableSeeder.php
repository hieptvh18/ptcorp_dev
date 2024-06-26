<?php

namespace Modules\Lms\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Models\WorkspaceInfo;
use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Models\Teamwork;

class WorkspaceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
        $user = User::find(41313);
        $owner = User::find(40984);
        $workspace_01 = WorkspaceInfo::create([
            'name' => 'Workspace 01',
            'short_name' => 'wp 01',
            'avatar_url' => 'https://avatar.jpg',
        ]);
        $team01 = $workspace_01->team()->create([
            'owner_id' => $owner->id,
            'name' => 'Teamwork ' . $workspace_01->short_name,
            'teamable_id' => $workspace_01->id
        ]);

        $team01->quizSchoolLevels()->attach(144);
        $owner->attachTeam($team01);
        $user->attachTeam($team01);
        $workspace_01->update([
            'teamwork_id' => $team01->id
        ]);

        $workspace_02 = WorkspaceInfo::create([
            'name' => 'Workspace 02',
            'short_name' => 'wp 02',
            'avatar_url' => 'https://avatar.jpg',
        ]);
        $team02 = $workspace_02->team()->create([
            'owner_id' => $owner->id,
            'name' => 'Teamwork ' . $workspace_01->short_name,
            'teamable_id' => $workspace_01->id
        ]);

        $team02->quizSchoolLevels()->attach(144);
        $owner->attachTeam($team02);
        $user->attachTeam($team02);
        $workspace_02->update([
            'teamwork_id' => $team02->id
        ]);

        $workspace_03 = WorkspaceInfo::create([
            'name' => 'Workspace 03',
            'short_name' => 'wp 03',
            'avatar_url' => 'https://avatar.jpg',
        ]);
        $team03 = $workspace_03->team()->create([
            'owner_id' => $owner->id,
            'name' => 'Teamwork ' . $workspace_03->short_name,
            'teamable_id' => $workspace_03->id
        ]);

        $team03->quizSchoolLevels()->attach(144);
        $owner->attachTeam($team03);
        $user->attachTeam($team03);
        $workspace_03->update([
            'teamwork_id' => $team03->id
        ]);

    }
}
