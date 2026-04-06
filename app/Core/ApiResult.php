<?php

declare(strict_types=1);

namespace FortniteHub\Core;

/**
 * Standardized API result transport object.
 */
final class ApiResult
{
    /**
     * @param array<string, mixed>|null $payload
     */
    public function __construct(
        public readonly bool $ok,
        public readonly int $statusCode,
        public readonly ?array $payload = null,
        public readonly ?string $errorType = null,
        public readonly ?string $errorMessage = null
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function success(array $payload, int $statusCode = 200): self
    {
        return new self(true, $statusCode, $payload, null, null);
    }

    public static function error(string $type, string $message, int $statusCode = 0): self
    {
        return new self(false, $statusCode, null, $type, $message);
    }
}
