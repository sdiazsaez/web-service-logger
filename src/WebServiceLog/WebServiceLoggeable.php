<?php

namespace Larangular\WebServiceLogger\WebServiceLog;

use Larangular\WebServiceLogger\Models\WebServiceLog;
use \Closure;

trait WebServiceLoggeable {

    private $wslController;

    public function getLog(
        int $objectId,
        string $objectType,
        string $clientService,
        string $provider,
        string $service,
        string $url,
        array $request,
        $expireTime = 0,
        Closure $filterCallback,
        Closure $serviceCallbackResponse): array {

        $wslController = $this->webServiceLogger_getWslController();

        $log = $wslController->getLog($objectId, $objectType, $clientService, $provider, $request, $expireTime);
        if ($this->webServiceLogger_hasNoValidResponse($log, $filterCallback)) {
            $serviceResponse = $serviceCallbackResponse();
            $response = $serviceResponse['response'];
            $xmlRequest = $serviceResponse['raw_request'];
            $xmlResponse = $serviceResponse['raw_response'];

            $wslController->makeLog(
                $objectId,
                $objectType,
                $clientService,
                $provider,
                $service,
                $url,
                $request,
                $response->toArray(),
                !$response->hasError,
                $xmlRequest,
                $xmlResponse
            );

            $log = $wslController->getLog($objectId, $objectType, $clientService, $provider, $request, $expireTime);
        }

        return $log->response;
    }

    private function webServiceLogger_getWslController(): WebServiceLogController {
        if (!isset($this->wslController)) {
            $this->wslController = new WebServiceLogController();
        }
        return $this->wslController;
    }

    private function webServiceLogger_hasNoValidResponse(WebServiceLog $log = null, Closure $filter): bool {
        return (!isset($log) || is_null($log) || $filter($log->response) || !$log->success);
    }


}
