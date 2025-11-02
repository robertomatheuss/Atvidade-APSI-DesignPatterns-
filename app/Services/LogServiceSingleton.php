<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LogServiceSingleton
{
    private const CACHE_KEY = 'app:last_logs';
    private const MAX = 100;

    /** @return array<int,array{ id:string,timestamp:string,level:string,message:string }> */
    public function all(): array
    {
        return Cache::get(self::CACHE_KEY, []);
    }

    public function info(string $message): void
    {
        $this->push('info', $message);
    }

    public function warn(string $message): void
    {
        $this->push('warn', $message);
    }

    public function error(string $message): void
    {
        $this->push('error', $message);
    }

    private function push(string $level, string $message): void
    {
        $logs = Cache::get(self::CACHE_KEY, []);

        $logs[] = [
            'id'        => Str::uuid()->toString(),
            'timestamp' => Carbon::now()->toISOString(),
            'level'     => $level,
            'message'   => $message,
        ];

        if (count($logs) > self::MAX) {
            $logs = array_slice($logs, -self::MAX);
        }
        Cache::forever(self::CACHE_KEY, $logs);
    }

    public function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
