<?php

declare(strict_types=1);

namespace FortniteHub\Core;

/**
 * Minimal .env loader without external dependencies.
 */
final class Env
{
    /**
     * @var array<string, string>
     */
    private static array $loaded = [];

    public static function load(string $path): void
    {
        if (!is_file($path) || !is_readable($path)) {
            return;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines === false) {
            return;
        }

        foreach ($lines as $line) {
            $trimmed = trim($line);
            if ($trimmed === '' || strpos($trimmed, '#') === 0) {
                continue;
            }

            if (strpos($line, '=') === false) {
                continue;
            }

            [$key, $value] = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            if ($key == '') {
                continue;
            }

            if (preg_match('/^(["\'])(.*)\\1$/', $value, $matches) === 1) {
                $value = $matches[2];
            }

            self::$loaded[$key] = $value;

            // Do not overwrite variables already defined by server/runtime.
            if (getenv($key) === false) {
                putenv($key . '=' . $value);
            }
            if (!isset($_ENV[$key])) {
                $_ENV[$key] = $value;
            }
            if (!isset($_SERVER[$key])) {
                $_SERVER[$key] = $value;
            }
        }
    }

    public static function get(string $key, ?string $default = null): ?string
    {
        if (array_key_exists($key, $_ENV)) {
            return (string) $_ENV[$key];
        }

        $value = getenv($key);
        if ($value !== false) {
            return (string) $value;
        }

        if (array_key_exists($key, self::$loaded)) {
            return self::$loaded[$key];
        }

        return $default;
    }

    public static function bool(string $key, bool $default = false): bool
    {
        $value = self::get($key);
        if ($value === null) {
            return $default;
        }

        $parsed = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        return $parsed ?? $default;
    }
}
