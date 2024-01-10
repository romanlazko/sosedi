<?php

namespace App\Bots\pozorbottestbot\Providers;

use Illuminate\Support\ServiceProvider;

class PozorbottestbotProvider extends ServiceProvider
{

    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../../pozor_sosedi_bot/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../../pozor_sosedi_bot/resources/views', 'pozor_sosedi_bot');
        $this->loadViewsFrom(__DIR__.'/../../pozor_sosedi_bot/resources/views', 'pozorbottestbot');
        $this->loadMigrationsFrom(__DIR__.'/../../pozor_sosedi_bot/database/migrations');
        $this->loadTranslationsFrom(__DIR__.'/../../pozor_sosedi_bot/resources/lang', 'baraholka');
    }
}
