<?php

Route::group([
    'prefix' => 'api/web-service-logger',
    'middleware' => 'api',
    'namespace' => 'Larangular\WebServiceLogger\Http\Controllers',
    'as' => 'larangular.api.web-service-logger.'
], function () {
    Route::resource('log', 'WebServiceLog\Gateway');
});
