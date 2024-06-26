<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('cache.cache_setting', [
            'cache_exam_enable' => false, 'cache_exam_time' => 300,
            'cache_banner_enable' => false, 'cache_banner_time' => 300, 'cache_document_enable' => false, 'cache_document_time' => 300,
            'cache_ebook_enable' => false, 'cache_ebook_time' => 300, 'cache_master_data_enable' => false, 'cache_master_data_time' => 300
        ]);
    }
};
