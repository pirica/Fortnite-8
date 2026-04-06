<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use FortniteHub\Models\FortniteAPI;

/**
 * FortniteAPI Model Unit Tests
 */
class FortniteAPITest extends TestCase
{
    private FortniteAPI $api;

    protected function setUp(): void
    {
        $_ENV['FORTNITE_API_KEY'] = 'test-key';
        $_ENV['FORTNITE_API_URL'] = 'http://127.0.0.1:9/';
        $_ENV['CACHE_ENABLED'] = 'false';

        putenv('FORTNITE_API_KEY=test-key');
        putenv('FORTNITE_API_URL=http://127.0.0.1:9/');
        putenv('CACHE_ENABLED=false');

        \FortniteHub\Core\Config::bootstrap(dirname(__DIR__, 2));
        
        $this->api = new FortniteAPI();
    }

    public function testCanBeInstantiated(): void
    {
        $this->assertInstanceOf(FortniteAPI::class, $this->api);
    }

    public function testGetShopReturnsStructuredFailureWhenApiUnavailable(): void
    {
        $result = $this->api->getShop();
        
        $this->assertIsArray($result);
        $this->assertArrayHasKey('status', $result);
        $this->assertArrayHasKey('error', $result);
        $this->assertArrayHasKey('error_type', $result);
        $this->assertNotSame(200, (int) $result['status']);
    }

    public function testSearchCosmeticsReturnsStructuredFailureWhenApiUnavailable(): void
    {
        $result = $this->api->searchCosmetics('Raven');
        
        $this->assertIsArray($result);
        $this->assertArrayHasKey('status', $result);
        $this->assertArrayHasKey('error', $result);
        $this->assertArrayHasKey('error_type', $result);
    }

    public function testInvalidCosmeticIdDoesNotReturnFatalNull(): void
    {
        $result = $this->api->getCosmetic('invalid_id_12345');
        
        $this->assertIsArray($result);
        $this->assertArrayHasKey('status', $result);
        $this->assertArrayHasKey('error', $result);
    }
}
