<?php

namespace Msd\WebServiceLogger\tests;

use Illuminate\Support\Carbon;
use Msd\WebServiceLogger\Http\Controllers\WebServiceLog\WebServiceLoggeable;
use Msd\WebServiceLogger\Models\WebServiceLog;
use Tests\TestCase;

class WebServiceLogTest extends TestCase {

    use WebServiceLoggeable;


    public function testGetLog() {
        $log = WebServiceLog::find(1486);

        $today = Carbon::now();
        $sub = Carbon::now()->subHour(24);
        dd([
            $log->created_at,
            $today,
            $sub
       ]);

        $responseLog = $this->getLog($log->idCotizacion, $log->method, $log->request);

        $this->assertTrue(($log->id === $responseLog->id));
    }
}
