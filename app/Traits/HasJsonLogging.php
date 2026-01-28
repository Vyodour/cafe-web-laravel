<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait HasJsonLogging
{
    /**
     * Log an action in JSON format.
     *
     * @param string $action The name of the action being logged.
     * @param array $data Additional data to include in the log.
     * @param string $level The log level (info, warning, error, etc.).
     * @return void
     */
    protected function logAction(string $action, array $data = [], string $level = 'info'): void
    {
        $logData = [
            'action' => $action,
            'invoked_by' => auth()->id() ?? 'system',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now()->toIso8601String(),
            'data' => $data,
        ];

        Log::channel('json')->log($level, $action, $logData);
    }
}
