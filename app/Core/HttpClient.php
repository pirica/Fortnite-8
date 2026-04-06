<?php

declare(strict_types=1);

namespace FortniteHub\Core;

/**
 * Small cURL wrapper for JSON APIs.
 */
final class HttpClient
{
    /**
     * @param array<int, string> $headers
     */
    public function getJson(string $url, array $headers = [], int $timeout = 20): ApiResult
    {
        $ch = curl_init();
        if ($ch === false) {
            return ApiResult::error('network', 'Falha ao inicializar cliente HTTP.');
        }

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_CONNECTTIMEOUT => 8,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 3,
            CURLOPT_HTTPHEADER => array_merge(['Accept: application/json'], $headers),
        ]);

        $response = curl_exec($ch);
        $statusCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            return ApiResult::error('network', 'Não foi possível conectar ao provedor externo.');
        }

        if ($curlError !== '') {
            return ApiResult::error('network', 'Erro de rede: ' . $curlError, $statusCode);
        }

        if ($statusCode < 200 || $statusCode >= 300) {
            return ApiResult::error('http', 'Resposta HTTP inesperada (' . $statusCode . ').', $statusCode);
        }

        $decoded = json_decode($response, true);
        if (!is_array($decoded)) {
            return ApiResult::error('invalid_payload', 'Payload JSON inválido recebido da API.', $statusCode);
        }

        return ApiResult::success($decoded, $statusCode);
    }
}
