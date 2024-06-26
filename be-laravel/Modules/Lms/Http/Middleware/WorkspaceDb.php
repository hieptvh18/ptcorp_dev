<?php

namespace Modules\Lms\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Artisan;

class WorkspaceDB
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $workspace_alias = $request->header('workspace');
        if ($workspace_alias) {
            try {
                $this->setConfigDatabase($workspace_alias);
                return $next($request);
            } catch (Exception $e) {
                abort(403, 'Workspace can not connection');
            }
        } else {
            abort(403, 'Workspace can not connection');
        }
        // if (auth()->check() && auth()->user()) {
        //     $user = auth()->user();
        //     $team = $user->currentTeam;
        //     if ($team) {
        //         $workspace = $team->teamable;
        //         $this->setConfigDatabase($workspace->alias);
        //         return $next($request);
        //     } else {
        //         abort(403);
        //     }
        // } else {
        //     abort(403);
        // }
    }

    public function setConfigDatabase($workspace_alias)
    {
        config([
            "database.connections.workspace_db.database" => "lms_$workspace_alias"
        ]);

        \Config::set(['database.default' => 'workspace_db']);
        Artisan::call("config:clear");
        DB::purge('workspace_db');
        DB::connection()->getPDO();
       
    }
}
