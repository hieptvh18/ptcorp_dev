<?php

namespace Modules\Lms\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UpdateMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'update:migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $workspaces = DB::connection('mysql')->table('auth_workspace_info')->get();
        foreach($workspaces as $workspace){
            config([
                'database.connections.workspace_db.database' => "lms_$workspace->short_name"
            ]);
            Artisan::call("config:clear");
            Artisan::call("migrate --database=workspace_db");
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            // ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
