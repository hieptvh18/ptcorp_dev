<?php

namespace Modules\Lms\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Lms\Models\Event;

class EventTableSeeder extends Seeder
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
        $events = [
            [
                'name' => 'event 01',
                'description' => 'event 01',
                'start_date' => '2023-08-12',
                'end_date' => '2023-09-20',
                'type' => 'ALL',
                'status' => 'PUBLISH',
                'created_by' => 40967
            ],
            [
                'name' => 'event 02',
                'description' => 'event 02',
                'start_date' => '2023-08-12',
                'end_date' => '2023-09-21',
                'type' => 'ALL',
                'status' => 'PUBLISH',
                'created_by' => 40967
            ],
            [
                'name' => 'event 03',
                'description' => 'event 03',
                'start_date' => '2023-08-12',
                'end_date' => '2023-09-22',
                'type' => 'ALL',
                'status' => 'PUBLISH',
                'created_by' => 40967
            ]
        ];
        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
