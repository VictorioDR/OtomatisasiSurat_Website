<?php

use App\Settings\GeneralSettings;

if (! function_exists('setting')) {
    function setting(string $key, $default = null)
    {
        $settings = app(GeneralSettings::class);

        return $settings->{$key} ?? $default;
    }
}
