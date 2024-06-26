<?php

namespace Modules\Lms\Services\Public;

use Exception;
use Illuminate\Http\Request;
use Modules\Lms\Models\Member;
use Modules\Lms\Models\LmsRole;
use Illuminate\Support\Facades\DB;
use Modules\Lms\Models\SchoolLevel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class PublicWorkspaceService
{
    public function runMigration(Request $request)
    {
        try {
            $this->setConnection($request->wp_alias);
            $moduleName = 'Lms';
            $moduleCms = 'Cms';
            DB::purge('workspace_db');
            Artisan::call("config:clear");
            if (!Schema::connection('workspace_db')->hasTable('migrations')) {
                Artisan::call("migrate:install --database=workspace_db ");
            }

            Artisan::call("render:migration lms_$request->wp_alias $moduleName ");
            Artisan::call("render:migration lms_$request->wp_alias $moduleCms ");
            Artisan::call("module:seed $moduleName --database=lms_$request->wp_alias");
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function addMember(Request $request)
    {
        try {
            $this->setConnection($request->wp_alias);
            DB::beginTransaction();
            $member_check = Member::where('email', $request->email)->exists();
            if ($request->email && !$member_check) {
                $member = Member::create([
                    'user_id' => $request->user_id,
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'birth_day' => $request->birth_day,
                    'mobile' => $request->mobile ?? '0989999999',
                    'email' => $request->email,
                    'type' => $request->type,
                    'avatar_url' => $request->avatar_url
                ]);

                $role = LmsRole::where('name', 'student')->first();

                $member->roles()->attach($role->id);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function syncSchoolLevel(Request $request)
    {
        try {
            $this->setConnection($request->wp_alias);
            DB::beginTransaction();
            $data = $request->all();
            SchoolLevel::create($data);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function syncMemberAdmin(Request $request)
    {
        try {
            $this->setConnection($request->wp_alias);
            DB::beginTransaction();
            $member = Member::create([
                'user_id' => $request->user_id,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'birth_day' => $request->birth_day,
                'mobile' => $request->mobile ?? '0989999999',
                'email' => $request->email,
                'type' => 'ADMIN',
                'avatar_url' => $request->avatar_url
            ]);
            $role = LmsRole::where(['name' => 'admin', 'bizapp_alias' => 'lms'])->first();
            $member->roles()->attach($role->id);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function removeMemberInWorkspace(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->setConnection($request->wp_alias);
            Member::whereIn('user_id', $request->user_ids)->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function setConnection($wp_alias)
    {
        config([
            "database.connections.workspace_db.database" => "lms_$wp_alias",
        ]);
        DB::purge('workspace_db');
    }
}
