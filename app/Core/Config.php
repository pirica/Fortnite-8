<?php

declare(strict_types=1);

namespace FortniteHub\Core;

/**
 * Centralized runtime configuration.
 */
final class Config
{
    /**
     * @var array<string, mixed>
     */
    private static array $config = [];

    public static function bootstrap(string $basePath): void
    {
        \FortniteHub\Core\Env::load($basePath . '/.env');

        $env = \FortniteHub\Core\Env::get('APP_ENV', 'production') ?? 'production';
        $debugDefault = $env !== 'production';
        $debug = \FortniteHub\Core\Env::bool('APP_DEBUG', $debugDefault);

        $configuredBaseUrl = trim((string) (\FortniteHub\Core\Env::get('APP_BASE_URL', '') ?? ''));
        $baseUrl = $configuredBaseUrl !== ''
            ? self::normalizeBaseUrl($configuredBaseUrl)
            : self::detectBaseUrl();

        self::$config = [
            'paths' => [
                'base' => $basePath,
                'cache' => $basePath . '/cache',
                'views' => $basePath . '/app/Views',
            ],
            'app' => [
                'env' => $env,
                'debug' => $debug,
                'url' => \FortniteHub\Core\Env::get('APP_URL', ''),
                'base_url' => $baseUrl,
            ],
            'cache' => [
                'enabled' => \FortniteHub\Core\Env::bool('CACHE_ENABLED', true),
                'ttl' => (int) (\FortniteHub\Core\Env::get('CACHE_TTL', '300') ?? '300'),
            ],
            'api' => [
                'fortnite_url' => rtrim((string) (\FortniteHub\Core\Env::get('FORTNITE_API_URL', 'https://fortnite-api.com/v2/') ?? 'https://fortnite-api.com/v2/'), '/') . '/',
                'fortnite_key' => (string) (\FortniteHub\Core\Env::get('FORTNITE_API_KEY', '') ?? ''),
            ],
        ];
    }

    /**
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        $segments = explode('.', $key);
        $value = self::$config;

        foreach ($segments as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return $default;
            }
            $value = $value[$segment];
        }

        return $value;
    }

    public static function baseUrl(): string
    {
        return (string) self::get('app.base_url', '');
    }

    public static function isDebug(): bool
    {
        return (bool) self::get('app.debug', false);
    }

    private static function detectBaseUrl(): string
    {
        if (PHP_SAPI === 'cli') {
            return '';
        }

        $scriptName = (string) ($_SERVER['SCRIPT_NAME'] ?? '');
        if ($scriptName === '') {
            return '';
        }

        $dir = str_replace('\\', '/', dirname($scriptName));
        if ($dir === '/' || $dir === '.' || $dir === '\\') {
            return '';
        }

        return rtrim($dir, '/');
    }

    private static function normalizeBaseUrl(string $value): string
    {
        $value = str_replace('\\', '/', $value);
        if ($value === '/' || $value === '') {
            return '';
        }

        return '/' . trim($value, '/');
    }
}
