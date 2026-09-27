<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Nnjeim\World\Geolocate\GeolocateService;

class TrustedProxyGeolocateService extends GeolocateService
{
    /**
     * Resolve the address through Laravel's configured trusted-proxy chain.
     *
     * Raw forwarding headers are intentionally ignored here. The ingress
     * controller is the only component allowed to establish the client IP.
     */
    public function getClientIp(): string
    {
        $ip = request()->ip() ?? '127.0.0.1';

        if (! $this->isPrivateIp($ip)) {
            return $ip;
        }

        return Cache::remember('world-ui:public-ip', now()->addMinutes(5), function () use ($ip): string {
            $response = Http::acceptJson()
                ->timeout(3)
                ->get(config('services.public_ip.url'), ['format' => 'json']);

            $publicIp = $response->successful() ? $response->json('ip') : null;

            return is_string($publicIp) && ! $this->isPrivateIp($publicIp)
                ? $publicIp
                : $ip;
        });
    }
}
