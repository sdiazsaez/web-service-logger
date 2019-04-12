<?php

namespace Larangular\WebServiceLogger\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Larangular\Installable\Facades\InstallableConfig;
use Larangular\RoutingController\Model as RoutingModel;

class WebServiceLog extends Model {
    use RoutingModel;

    protected $fillable   = [
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

    protected $casts = [
        'request'  => 'array',
        'response' => 'array',
    ];


    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->installableConfig = InstallableConfig::config('Larangular\WebServiceLogger\WebServiceLoggerServiceProvider');
        $this->table = $this->installableConfig->getName('web_service_log');
        $this->connection = $this->installableConfig->getConnection('web_service_log');
        $this->timestamps = $this->installableConfig->getTimestamp('web_service_log');
    }

    public function setRequestAttribute($request) {
        if (!isset($request)) return;
        $request = json_encode($request);
        $this->attributes['request'] = $request;
        $this->setRequestId($request);
    }

    private function setRequestId($request) {
        $this->attributes['request_id'] = md5($request);
    }

    public function scopeNewerThan($query, $hours = 0) {
        if($hours == 0) {
            return $query;
        }
        return $query->where('created_at', '>=', Carbon::now()->subHour($hours));
    }

    public function scopeByRequest($query, $request) {
        $request = md5(json_encode($request));
        return $query->where('request_id', $request);
    }
}
