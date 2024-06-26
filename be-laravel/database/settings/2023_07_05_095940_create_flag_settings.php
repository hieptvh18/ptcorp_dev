<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('flag.flag', [
            'flag_setting' => [
                'name' => 'VIETNAM',
                'iso_code' => 'vi',
                'image' => '<x-flag-country-vi />',
                'enable' => true
            ]
        ]);
    }
};
