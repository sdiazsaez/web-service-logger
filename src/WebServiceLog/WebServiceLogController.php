<?php

namespace Larangular\WebServiceLogger\WebServiceLog;

use Larangular\WebServiceLogger\Models\WebServiceLog;
use Larangular\WebServiceLogger\Http\Controllers\WebServiceLog\Gateway;

class WebServiceLogController {

    private $gateway;

    public function __construct() {
        $this->gateway = new Gateway();
    }

    public function makeLog(int $objectId, string $objectType, string $clientService, string $provider, string $service,
        string $url, array $request, array $response, bool $success): void {
        $this->gateway->save([
            'object_id'      => $objectId,
            'object_type'    => $objectType,
            'client_service' => $clientService,
            'provider'       => $provider,
            'service'        => $service,
            'url'            => $url,
            'request'        => $request,
            'response'       => $response,
            'success'        => $success,
        ]);

    }

    public function getLog(int $objectId, string $objectType, string $clientService, string $provider, array $request,
        int $expireTime): WebServiceLog {
        return WebServiceLog::where([
            'object_id'      => $objectId,
            'object_type'    => $objectType,
            'client_service' => $clientService,
            'provider'       => $provider,
        ])
                            ->ByRequest($request)
                            ->NewerThan($expireTime)
                            ->orderBy('created_at', 'desc')
                            ->first();
    }

}

