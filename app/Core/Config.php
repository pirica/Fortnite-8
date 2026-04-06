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

    /**
     * @var array<int, string>
     */
    private static array $warnings = [];

    public static function bootstrap(string $basePath): void
    {
        \FortniteHub\Core\Env::load($basePath . '/.env');

        self::$warnings = [];

        $envRaw = \FortniteHub\Core\Env::get('APP_ENV', 'production') ?? 'production';
        $env = self::normalizeEnv($envRaw);
        $debugDefault = $env !== 'production';
        $debug = \FortniteHub\Core\Env::bool('APP_DEBUG', $debugDefault);

        $configuredBaseUrl = trim((string) (\FortniteHub\Core\Env::get('APP_BASE_URL', '') ?? ''));
        $baseUrl = $configuredBaseUrl !== ''
            ? self::normalizeBaseUrl($configuredBaseUrl)
            : self::detectBaseUrl();

        $cacheTtl = (int) (\FortniteHub\Core\Env::get('CACHE_TTL', '300') ?? '300');
        if ($cacheTtl <= 0) {
            $cacheTtl = 300;
            self::$warnings[] = 'CACHE_TTL inválido; fallback aplicado para 300 segundos.';
        }

        $apiUrl = (string) (\FortniteHub\Core\Env::get('FORTNITE_API_URL', 'https://fortnite-api.com/v2/') ?? 'https://fortnite-api.com/v2/');
        $apiUrl = self::normalizeApiUrl($apiUrl);

        $apiKey = trim((string) (\FortniteHub\Core\Env::get('FORTNITE_API_KEY', '') ?? ''));
        if ($env === 'production' && $apiKey === '') {
            self::$warnings[] = 'FORTNITE_API_KEY não configurada em produção; recursos de API podem falhar.';
        }

        $strictConfig = \FortniteHub\Core\Env::bool('APP_STRICT_CONFIG', false);
        if ($strictConfig && $env === 'production' && $apiKey === '') {
            throw new \RuntimeException('APP_STRICT_CONFIG está ativo, mas FORTNITE_API_KEY não foi configurada em produção.');
        }

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
                'strict_config' => $strictConfig,
            ],
            'cache' => [
                'enabled' => \FortniteHub\Core\Env::bool('CACHE_ENABLED', true),
                'ttl' => $cacheTtl,
            ],
            'api' => [
                'fortnite_url' => $apiUrl,
                'fortnite_key' => $apiKey,
            ],
        ];
    }

    /**
     * @return array<int, string>
     */
    public static function warnings(): array
    {
        return self::$warnings;
    }

    public static function hasWarnings(): bool
    {
        return self::$warnings !== [];
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

    public static function isStrictConfig(): bool
    {
        return (bool) self::get('app.strict_config', false);
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

    private static function normalizeEnv(string $env): string
    {
        $normalized = strtolower(trim($env));
        $allowed = ['production', 'development', 'testing'];

        if (!in_array($normalized, $allowed, true)) {
            self::$warnings[] = 'APP_ENV inválido; fallback aplicado para production.';
            return 'production';
        }

        return $normalized;
    }

    private static function normalizeApiUrl(string $url): string
    {
        $normalized = trim($url);
        if ($normalized === '') {
            self::$warnings[] = 'FORTNITE_API_URL vazia; fallback aplicado para URL padrão.';
            return 'https://fortnite-api.com/v2/';
        }

        if (filter_var($normalized, FILTER_VALIDATE_URL) === false) {
            self::$warnings[] = 'FORTNITE_API_URL inválida; fallback aplicado para URL padrão.';
            return 'https://fortnite-api.com/v2/';
        }

        return rtrim($normalized, '/') . '/';
    }
}
