<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('chanel_on_thi_thpt.title', 'Spatie');
        $this->migrator->add('chanel_on_thi_thpt.filter_exams', ['defalut' => 'defalut']);
    }
};
