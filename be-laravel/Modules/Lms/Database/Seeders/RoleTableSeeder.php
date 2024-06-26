<?php

namespace Modules\Lms\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Lms\Models\LmsRole;

class RoleTableSeeder extends Seeder
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
        $roles = [
            [
                'name' => 'admin',
                'guard_name' => 'api',
                'label' => 'Admin',
                'bizapp_alias' => 'lms',
                'is_active' => true
            ],
            [
                'name' => 'teacher',
                'guard_name' => 'api',
                'label' => 'Giáo viên',
                'bizapp_alias' => 'lms',
                'is_active' => true
            ],
            [
                'name' => 'student',
                'guard_name' => 'api',
                'label' => 'Học viên',
                'bizapp_alias' => 'lms',
                'is_active' => true
            ]

        ];

        foreach($roles as $role){
            LmsRole::create($role);
        }
    }
}
