<?php

namespace Larangular\WebServiceLogger\Http\Controllers\WebServiceLog;

use Larangular\RoutingController\{Controller, Contracts\HasResource, Contracts\IGatewayModel};
use Larangular\WebServiceLogger\Models\WebServiceLog;
use Larangular\WebServiceLogger\Http\Resources\WebServiceLogResource;

class Gateway extends Controller implements IGatewayModel, HasResource {

    public function model() {
        return WebServiceLog::class;
    }

    public function resource() {
        return WebServiceLogResource::class;
    }
}
