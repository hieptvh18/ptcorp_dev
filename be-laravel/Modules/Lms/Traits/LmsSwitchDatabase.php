<?php

namespace Modules\Lms\Traits;

use Illuminate\Support\Facades\DB;


trait LmsSwitchDatabase
{

    public function setConfigDatabase($workspace_alias)
    {
        config([
            "database.connections.workspace_db.database" => "lms_$workspace_alias"
        ]);
        DB::purge('workspace_db');
    }
}
