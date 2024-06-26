<?php

namespace Modules\Lms\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Modules\Auth\Models\WorkspaceInfo;
use Illuminate\Support\Facades\Artisan;
use Nwidart\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class RenderMigration extends Command
{
    use ModuleCommandTrait;

    /**
     * The name of argument being used.
     *
     * @var string
     */
    protected $argumentName = 'database_name';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'render:migration';

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
        $database_name = $this->argument('database_name');
        $moduleName = $this->argument('module');
        config([
            'database.connections.workspace_db.database' => $database_name
        ]);
        DB::purge('workspace_db');
        Artisan::call("config:clear");
        Artisan::call("module:migrate $moduleName --database=workspace_db --force");

        Artisan::call("migrate --path=/database/migrations/2023_02_28_135821_create_reviews_table.php --database=workspace_db --force");
        Artisan::call("migrate --path=/database/migrations/2023_03_02_110017_alter_reviews_table.php --database=workspace_db --force");
        Artisan::call("migrate --path=/database/migrations/2023_03_02_141740_alter_reviewrateable_reviews_table.php --database=workspace_db --force");
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['database_name', InputArgument::REQUIRED, 'the name database argument.'],
            ['module', InputArgument::OPTIONAL, 'The name of module will be used.'],
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
