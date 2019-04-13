<?php

namespace Larangular\WebServiceLogger;

use Larangular\Installable\Support\{InstallableServiceProvider as ServiceProvider, PublisableGroups, PublishableGroups};
use Larangular\Installable\{Contracts\HasInstallable,
    Contracts\Installable,
    Installer\Installer};


class WebServiceLoggerServiceProvider extends ServiceProvider implements HasInstallable {

    public function boot() {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    public function register() {
        $this->declareMigrationGlobal();
        $this->declareMigrationWebServiceLog();
    }

    public function installer(): Installable {
        return new Installer(__CLASS__);
    }

    private function declareMigrationGlobal(): void {
        $this->declareMigration([
            'connection'   => 'mysql',
            'migrations'   => [
                'local_path' => base_path() . '/vendor/larangular/web-service-logger/database/migrations',
            ],
            'seeds'        => [
                'local_path' => __DIR__ . '/../database/seeds',
            ],
            'seed_classes' => [],
        ]);
    }

    private function declareMigrationWebServiceLog() {
        $this->declareMigration([
            'name'      => 'web_service_log',
            'timestamp' => true,
        ]);
    }
}
