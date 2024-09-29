<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Console\ClientCommand;
use Laravel\Passport\Console\InstallCommand;
use Laravel\Passport\Console\KeysCommand;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Schema;
use Laravel\Telescope\TelescopeServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
       /*ADD THIS LINES*/
    $this->commands([
      InstallCommand::class,
      ClientCommand::class,
      KeysCommand::class,
  ]);
    // // If you want to use the facade to log messages
    // $loader = \Illuminate\Foundation\AliasLoader::getInstance();
    // $loader->alias('Debugbar', \Barryvdh\Debugbar\Facades\Debugbar::class);

    if ($this->app->environment('local')) {
      $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
      $this->app->register(TelescopeServiceProvider::class);
  }

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
            Schema::defaultStringLength(191);

      $registrar = new \App\Routing\ResourceRegistrar($this->app['router']);

      $this->app->bind('Illuminate\Routing\ResourceRegistrar', function () use ($registrar) {
          return $registrar;
      });
      $this->app->bind(GeneratePdfService::class);
      $this->app->bind(PaymentMethodService::class);
      $this->app->bind(ProccessCodesService::class);
      $this->app->bind(SendingMessagesService::class);
      $this->app->bind(SendingNotificationsService::class);

      $this->app->bind(Paypal::class);


    }
}
