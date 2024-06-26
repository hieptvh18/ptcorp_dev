<?php

namespace Modules\Cms\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Cms\Models\CourseLanguage;

class CmsCourseLanguageTableSeeder extends Seeder
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

        $languages = [
            [
                'name' => 'Tiếng Việt',
                'code' => 'vn',
                'flag' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/Flag_of_North_Vietnam_%281955%E2%80%931976%29.svg/158px-Flag_of_North_Vietnam_%281955%E2%80%931976%29.svg.png',
                'is_active' => 1,
            ]
        ];

        foreach($languages as $lang){
            CourseLanguage::create($lang);
        }
    }
}
