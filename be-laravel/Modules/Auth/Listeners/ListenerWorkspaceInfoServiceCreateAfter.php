<?php

namespace Modules\Auth\Listeners;

use PDO;
use PDOException;
use App\Models\User;
use GuzzleHttp\Client;
use Modules\Lms\Models\Member;
use Modules\Lms\Models\LmsRole;
use App\Exceptions\ApiException;
use Illuminate\Support\Facades\DB;
use Modules\Lms\Models\SchoolLevel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;
use Modules\Lms\Models\QuizSchoolLevel;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Auth\Events\EventWorkspaceInfoServiceCreateAfter;

class ListenerWorkspaceInfoServiceCreateAfter
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param EventWorkspaceInfoServiceCreateAfter $event
     * @return void
     */
    public function handle(EventWorkspaceInfoServiceCreateAfter $event)
    {
        $workspaceInfo = $event->workspaceInfo;
        $user = User::where('id', $workspaceInfo->created_by)->first();
        $level_schools = $this->createTeamwork($workspaceInfo);
        $this->createDbWorkspace($workspaceInfo);
        $this->runMigrationLms($workspaceInfo->alias);
        $this->createSchoolLevel($workspaceInfo, $level_schools);
        $this->createMemberAdmin($workspaceInfo, $user);
    }

    public function runMigrationLms($wp_alias)
    {
        Http::post(config('auth.service_url.lms')."/lms/api/public/v1/run-migration", [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'wp_alias' => $wp_alias,
        ]);
    }

    public function createTeamwork($workspaceInfo)
    {
        $user = User::where('id', $workspaceInfo->created_by)->first();
        $team = $workspaceInfo->team()->create([
            'owner_id' => $user->id,
            'name' => 'Teamwork ' . $workspaceInfo->short_name,
            'teamable_id' => $workspaceInfo->id,
            'teamable_type' => get_class($workspaceInfo)
        ]);

        $team->quizSchoolLevels()->sync(request('level_school_ids'));

        $school_levels = $team->quizSchoolLevels->toArray();

        $user->attachTeam($team);

        $workspaceInfo->update([
            'teamwork_id' => $team->id,
        ]);

        return $school_levels;
    }

    public function createDbWorkspace($workspaceInfo)
    {
        try {
            $charset = config("database.connections.workspace_db.charset", 'utf8mb4');
            $collation = config("database.connections.workspace_db.collation", 'utf8mb4_unicode_ci');

            config(["database.connections.workspace_db.database" => null]);

            $sql = "CREATE DATABASE IF NOT EXISTS `lms_$workspaceInfo->alias` CHARACTER SET $charset COLLATE $collation;";
            DB::statement($sql);
        } catch (PDOException $e) {

            throw new ApiException($e->getMessage());
        }
    }

    public function createMemberAdmin($workspace, $user)
    {
        Http::post(config('auth.service_url.lms')."/lms/api/public/v1/sync-member-admin", [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'wp_alias' => $workspace->alias,
            'user_id' => $user->id,
            'firstname' => $user->info->first_name,
            'lastname' => $user->info->last_name,
            'birth_day' => $user->info->birthday,
            'mobile' => $user->mobile ?? '0989999999',
            'email' => $user->email,
            'type' => 'ADMIN',
            'avatar_url' => $user->info->avatar_url
        ]);
    }

    public function createSchoolLevel($workspace, $school_levels)
    {
        foreach ($school_levels as $school_level) {
            Http::post(config('auth.service_url.lms')."/lms/api/public/v1/sync-school-level", [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'wp_alias' => $workspace->alias,
                'name' => $school_level['name'],
                'code' => $school_level['code'],
                'alias' => $school_level['alias'],
                'description' => $school_level['description'],
                'is_active' => $school_level['is_active'],
                'created_by' => $school_level['created_by']
            ]);

        }
    }
}
