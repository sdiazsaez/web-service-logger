<?php

namespace Larangular\WebServiceLogger\Http\Controllers\WebServiceLog;

use Larangular\WebServiceLogger\Models\WebServiceLog;

trait WebServiceLoggeable {

    private $wslController;

    public function getLog($quoteId, $method, $request, $expireTime = 0, $filterCallback, $serviceCallbackResponse) {
        $wslController = $this->getWslController();

        $log = $wslController->getLog($quoteId, $method, $request, $expireTime);
        if ($this->hasNoValidResponse($log, $filterCallback)) {
            $wslController->makeLog($quoteId, $method, '', $request, $serviceCallbackResponse());
            $log = $wslController->getLog($quoteId, $method, $request, $expireTime);
        }

        return $log->response;
    }

    private function getWslController() {
        if (!isset($this->wslController)) {
            $this->wslController = new WebServiceLogController();
        }
        return $this->wslController;
    }

    private function hasNoValidResponse(WebServiceLog $log = null, $filter): bool {
        return (!isset($log) || is_null($log) || $filter($log->response));
    }


}
