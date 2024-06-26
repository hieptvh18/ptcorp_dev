<?php

namespace Modules\Auth\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Models\Role;
use Modules\Core\Models\Bizapp;

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
        Bizapp::truncate();
        DB::statement("SET foreign_key_checks=0");
        $bizapp = Bizapp::create([
            'name' => 'LMS',
            'alias' => 'lms',
            'is_active' => true,
        ]);

        Role::truncate();
        DB::statement("SET foreign_key_checks=1");

        $roles = [
            [
                'name' => 'admin',
                'guard_name' => 'api',
                'label' => 'Admin',
                'bizapp_alias' => $bizapp->alias,
                'is_active' => true
            ],
            [
                'name' => 'teacher',
                'guard_name' => 'api',
                'label' => 'Giáo viên',
                'bizapp_alias' => $bizapp->alias,
                'is_active' => true
            ],
            [
                'name' => 'student',
                'guard_name' => 'api',
                'label' => 'Học viên',
                'bizapp_alias' => $bizapp->alias,
                'is_active' => true
            ],
            [
                'name' => 'staff',
                'guard_name' => 'api',
                'label' => 'Nhân viên',
                'bizapp_alias' => $bizapp->alias,
                'is_active' => true
            ]

        ];

        foreach($roles as $role){
            Role::create($role);
        }
    }
}
