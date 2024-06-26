<?php

namespace Modules\Lms\Console;

use Illuminate\Console\Command;
use Modules\Lms\Services\User\NotificationService;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CronHandleScheduleNotificationConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'lms_notification:config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check schedule notification config.';

    protected $notificationService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->notificationService->handleNotificationToUser();
    }
}
