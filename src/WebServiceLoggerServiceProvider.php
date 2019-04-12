<?php

namespace Larangular\WebServiceLogger;

use Larangular\Installable\Support\{InstallableServiceProvider as ServiceProvider, PublisableGroups, PublishableGroups};
use Larangular\Installable\{Contracts\HasInstallable,
    Contracts\Installable,
    Installer\Installer};


class WebServiceLoggerServiceProvider extends ServiceProvider implements HasInstallable {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        $this->declareMigration([
            'name'       => 'webserviceLog',
            'connection' => 'mysql',
            'timestamp'  => true,
            'local_path' => __DIR__ . '/../database/migrations',
            'publish_path' => database_path('migrations/web-service-logger')
        ]);

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
    }

    public function installer(): Installable {
        return new Installer(__CLASS__);
    }
}
