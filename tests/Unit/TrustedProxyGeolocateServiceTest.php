<?php

namespace Tests\Unit;

use App\Services\TrustedProxyGeolocateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Nnjeim\World\Geolocate\GeolocateService;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Tests\TestCase;

class TrustedProxyGeolocateServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Cache::forget('world-ui:public-ip');
        Request::setTrustedProxies([], -1);

        parent::tearDown();
    }

    public function test_application_binds_the_trusted_proxy_implementation(): void
    {
        $this->assertInstanceOf(
            TrustedProxyGeolocateService::class,
            $this->app->make(GeolocateService::class),
        );
    }

    public function test_it_uses_laravels_trusted_proxy_result_and_ignores_cloudflare_header(): void
    {
        Request::setTrustedProxies(
            ['10.42.3.0'],
            SymfonyRequest::HEADER_X_FORWARDED_FOR,
        );

        $request = Request::create('/', server: [
            'REMOTE_ADDR' => '10.42.3.0',
            'HTTP_X_FORWARDED_FOR' => '8.8.4.4',
            'HTTP_CF_CONNECTING_IP' => '1.1.1.1',
        ]);

        $this->app->instance('request', $request);

        $this->assertSame(
            '8.8.4.4',
            $this->app->make(GeolocateService::class)->getClientIp(),
        );

        Http::assertNothingSent();
    }

    public function test_it_resolves_the_public_egress_address_for_a_private_hairpin_address(): void
    {
        config()->set('services.public_ip.url', 'https://api.ipify.org');

        Http::fake([
            'api.ipify.org*' => Http::response(['ip' => '8.8.4.4']),
        ]);

        $request = Request::create('/', server: [
            'REMOTE_ADDR' => '10.28.10.1',
        ]);

        $this->app->instance('request', $request);

        $this->assertSame(
            '8.8.4.4',
            $this->app->make(GeolocateService::class)->getClientIp(),
        );

        Http::assertSentCount(1);
    }
}
