<?php

namespace Larangular\WebServiceLogger\WebServiceLog;

use Larangular\WebServiceLogger\Models\WebServiceLog;
use Larangular\WebServiceLogger\Http\Controllers\WebServiceLog\Gateway;

class WebServiceLogController {

    private $gateway;

    public function __construct() {
        $this->gateway = new Gateway();
    }

    public function makeLog($quoteId, $method, $url, $request, $response) {
        $this->gateway->save(
            [
                'idCotizacion' => $quoteId,
                'method'       => $method,
                'url'          => $url,
                'request'      => $request,
                'response'     => $response,
            ]
        );

    }

    public function getLog(int $object_id, $method, $request, $expireTime) {
        $fillable   = [
            'object_id',
            'object_type',
            'client_service',
            'provider',
            'service',
            'url',
            'request_id',
            'request',
            'response',
            'response_status'
        ];
        return WebServiceLog::where(
            [
                'object_id' => $object_id,
                'method'       => $method,
            ]
        )
                            ->ByRequest($request)
                            ->NewerThan($expireTime)
                            ->orderBy('created_at', 'desc')
                            ->first();
    }

}

