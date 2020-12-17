<?php

namespace Larangular\WebServiceLogger\Http\Controllers\WebServiceLog;

use Larangular\RoutingController\{Contracts\IGatewayModel, Controller};
use Larangular\WebServiceLogger\Models\WebServiceLog;

class Gateway extends Controller implements IGatewayModel {

    public function model() {
        return WebServiceLog::class;
    }

}
