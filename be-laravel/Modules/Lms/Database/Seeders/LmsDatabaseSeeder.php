<?php

namespace Modules\Lms\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class LmsDatabaseSeeder extends Seeder
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
        // $this->call(WorkspaceTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(NotificationTableSeeder::class);
        $this->call(EventTableSeeder::class);
    }
}
