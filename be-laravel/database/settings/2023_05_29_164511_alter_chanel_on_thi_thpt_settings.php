<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->delete('chanel_on_thi_thpt.title');
        $this->migrator->delete('chanel_on_thi_thpt.filter_exams');
        $this->migrator->add('chanel_on_thi_thpt.thpt', ['defalut' => 'defalut']);
    }
};
