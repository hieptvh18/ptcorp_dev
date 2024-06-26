<?php

namespace Modules\Auth\Console;

use App\Models\User;
use Illuminate\Console\Command;
use Modules\Core\Models\RewardPoint;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SyncRewardPoint extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'sync:reward-point';

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
        $uesrs = User::all();
        $bar = $this->output->createProgressBar(count($uesrs));
        $this->info("count uesr ===> ".count($uesrs));
        $bar->start();
        foreach ($uesrs as $uesr) {
            RewardPoint::create([
                'user_id' => $uesr->id,
                'reward_point' => $uesr->reputation
            ]);
            $bar->advance();
        }
        $bar->finish();
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
