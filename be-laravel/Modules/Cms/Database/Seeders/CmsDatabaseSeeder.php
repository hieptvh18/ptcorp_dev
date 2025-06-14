<?php

namespace Modules\Cms\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Cms\Database\Seeders\CmsCourseLanguageTableSeeder;

class CmsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

         $this->call(CmsCourseLanguageTableSeeder::class);
    }
}
