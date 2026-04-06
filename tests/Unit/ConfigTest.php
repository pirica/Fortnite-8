<?php

declare(strict_types=1);

namespace Tests\Unit;

use FortniteHub\Core\Config;
use FortniteHub\Core\Env;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    /**
     * @var array<int, string>
     */
    private array $keys = [
        'APP_ENV',
        'APP_DEBUG',
        'APP_STRICT_CONFIG',
        'CACHE_TTL',
        'FORTNITE_API_URL',
        'FORTNITE_API_KEY',
        'APP_BASE_URL',
    ];

    protected function setUp(): void
    {
        Env::reset();

        foreach ($this->keys as $key) {
            unset($_ENV[$key], $_SERVER[$key]);
            putenv($key);
        }
    }

    protected function tearDown(): void
    {
        foreach ($this->keys as $key) {
            unset($_ENV[$key], $_SERVER[$key]);
            putenv($key);
        }

        Env::reset();
        Config::bootstrap(dirname(__DIR__, 2));
    }

    public function testInvalidAppEnvFallsBackToProductionAndWarns(): void
    {
        $_ENV['APP_ENV'] = 'invalid-env';
        putenv('APP_ENV=invalid-env');

        Config::bootstrap(dirname(__DIR__, 2));

        $this->assertSame('production', Config::get('app.env'));
        $this->assertTrue(Config::hasWarnings());
        $this->assertContains('APP_ENV inválido; fallback aplicado para production.', Config::warnings());
    }

    public function testInvalidApiUrlFallsBackAndWarns(): void
    {
        $_ENV['FORTNITE_API_URL'] = 'not-an-url';
        putenv('FORTNITE_API_URL=not-an-url');

        Config::bootstrap(dirname(__DIR__, 2));

        $this->assertSame('https://fortnite-api.com/v2/', Config::get('api.fortnite_url'));
        $this->assertContains('FORTNITE_API_URL inválida; fallback aplicado para URL padrão.', Config::warnings());
    }

    public function testInvalidCacheTtlFallsBackToDefaultAndWarns(): void
    {
        $_ENV['CACHE_TTL'] = '0';
        putenv('CACHE_TTL=0');

        Config::bootstrap(dirname(__DIR__, 2));

        $this->assertSame(300, Config::get('cache.ttl'));
        $this->assertContains('CACHE_TTL inválido; fallback aplicado para 300 segundos.', Config::warnings());
    }

    public function testMissingApiKeyInProductionAddsWarning(): void
    {
        $_ENV['APP_ENV'] = 'production';
        $_ENV['FORTNITE_API_KEY'] = '';
        putenv('APP_ENV=production');
        putenv('FORTNITE_API_KEY=');

        Config::bootstrap(dirname(__DIR__, 2));

        $this->assertContains('FORTNITE_API_KEY não configurada em produção; recursos de API podem falhar.', Config::warnings());
    }

    public function testStrictConfigInProductionThrowsWithoutApiKey(): void
    {
        $_ENV['APP_ENV'] = 'production';
        $_ENV['APP_STRICT_CONFIG'] = 'true';
        $_ENV['FORTNITE_API_KEY'] = '';
        putenv('APP_ENV=production');
        putenv('APP_STRICT_CONFIG=true');
        putenv('FORTNITE_API_KEY=');

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('APP_STRICT_CONFIG está ativo');

        Config::bootstrap(dirname(__DIR__, 2));
    }
}
