<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Larangular\Installable\Facades\InstallableConfig;
use Larangular\MigrationPackage\Migration\Schematics;

class CreateWebServiceLogTable extends Migration {
    use Schematics;
    protected $name;
    private   $hasTimestamp;

    public function __construct() {
        $installableConfig = InstallableConfig::config('Larangular\WebServiceLogger\WebServiceLoggerServiceProvider');
        $this->connection = $installableConfig->getConnection('web_service_log');
        $this->name = $installableConfig->getName('web_service_log');
        $this->hasTimestamp = $installableConfig->getTimestamp('web_service_log');
    }

    public function up() {
        $this->create(function (Blueprint $table) {
            $table->increments('id')
                  ->unsigned();
            $table->integer('object_id')
                  ->unsigned();
            $table->string('object_type');
            $table->string('client_service');
            $table->string('provider');
            $table->string('service');
            $table->string('url');
            $table->string('request_id');
            $table->json('request');
            $table->json('response');
            $table->boolean('success');
            if ($this->hasTimestamp) {
                $table->softDeletes();
                $table->timestamps();
            }
        });
    }

    public function down() {
        $this->drop();
    }
}

