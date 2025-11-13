<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use App\Domains\Settings\Repositories\SettingEntityRepository;

class SettingsServiceProvider extends ServiceProvider
{
    public function boot(SettingEntityRepository $repository)
    {
        Config::set('settings', $repository->all()->first()?->toArray() ?? []);
    }
}
