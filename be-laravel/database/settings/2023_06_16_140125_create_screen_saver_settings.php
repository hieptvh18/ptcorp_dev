<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('screen_saver.screen_saver', ['defalut' => 'defalut']);
    }
};
