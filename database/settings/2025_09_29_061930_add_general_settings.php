<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_name', 'Surat Otomatis');
        $this->migrator->add('general.site_logo', 'logos/logo.png');
    }
};
