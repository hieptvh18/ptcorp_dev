<?php

namespace App\Console;

use App\Console\Commands\ModuleRepository;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ModuleRepository::class
        // 'Modules\Core\Console\BlogCommand',
        // 'Modules\Auth\Console\BlockUserCommand',
        // 'Modules\Core\Console\UserMissionStatus',
        // 'Modules\Quiz\Console\ConfigShareExamCommand',
        // 'Modules\Quiz\Console\MasterDataTranslate',
        // 'Modules\Quiz\Console\Ranking\SyncDataExamRank',
        // 'Modules\Quiz\Console\SyncExamChanel',
        // 'Modules\Quiz\Console\Exam\DisableTranslateExam',
        // 'Modules\Quiz\Console\Ranking\SyncDataChanelRank',
        // 'Modules\Quiz\Console\Exam\SyncDataStatisExam',
        // 'Modules\Quiz\Console\Exam\SyncDataStatisExamToday',
        // 'Modules\Quiz\Console\SyncRewardPointNotification',
        // 'Modules\Auth\Console\SyncRewardPoint',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->command('blog:update')->timezone('Asia/Ho_Chi_Minh')->dailyAt('7:00');
        // $schedule->command('user:update')->timezone('Asia/Ho_Chi_Minh')->dailyAt('7:00');
        // $schedule->command('userMissionStatus:update')->timezone('Asia/Ho_Chi_Minh')->everyFiveMinutes();
        // // $schedule->command('configShareExam:create')->timezone('Asia/Ho_Chi_Minh');
        // $schedule->command('masterData:disable-translate')->timezone('Asia/Ho_Chi_Minh');
        // $schedule->command('sync-ranking:exam')->timezone('Asia/Ho_Chi_Minh');
        // $schedule->command('sync-user:exam-chanel')->timezone('Asia/Ho_Chi_Minh');
        // $schedule->command('exam:disable-translate')->timezone('Asia/Ho_Chi_Minh');
        // $schedule->command('sync-ranking:chanel')->timezone('Asia/Ho_Chi_Minh');
        // $schedule->command('exam:statis')->timezone('Asia/Ho_Chi_Minh');
        // $schedule->command('exam:statis-today')->timezone('Asia/Ho_Chi_Minh')->hourly();
        // $schedule->command('notification:reward_point')->timezone('Asia/Ho_Chi_Minh')->dailyAt('23:00');
        // $schedule->command('sync:reward-point')->timezone('Asia/Ho_Chi_Minh');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        // require base_path('routes/console.php');
    }
}
