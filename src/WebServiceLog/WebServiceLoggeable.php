<?php

namespace Larangular\WebServiceLogger\WebServiceLog;

use Larangular\WebServiceLogger\Models\WebServiceLog;
use \Closure;

trait WebServiceLoggeable {

    private $wslController;

    public function getLog(int $objectId, $method, $request, $expireTime = 0, Closure $filterCallback, Closure $serviceCallbackResponse): array {
        $wslController = $this->webServiceLogger_getWslController();

        $log = $wslController->getLog($objectId, $method, $request, $expireTime);
        if ($this->webServiceLogger_hasNoValidResponse($log, $filterCallback)) {
            $wslController->makeLog($objectId, $method, '', $request, $serviceCallbackResponse());
            $log = $wslController->getLog($objectId, $method, $request, $expireTime);
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
        return (!isset($log) || is_null($log) || $filter($log->response));
    }


}
