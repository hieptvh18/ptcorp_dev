<?php

namespace Modules\Lms\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Lms\Models\Notification;

class NotificationTableSeeder extends Seeder
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
        $notifications = [
            [
                'title' => 'notification 01',
                'member_id' => 1,
                'created_by' => 40967
            ],
            [
                'title' => 'notification 02',
                'member_id' => 1,
                'created_by' => 40967
            ],
            [
                'title' => 'notification 03',
                'member_id' => 1,
                'created_by' => 40967
            ],
            [
                'title' => 'notification 04',
                'member_id' => 1,
                'created_by' => 40967
            ]
        ];

        foreach($notifications as $notification){
            Notification::create($notification);
        }
    }
}
