<?php

namespace Core;

class ApiResponse
{
    public static function success($data = [], string $message = "Success", int $statusCode = 200): void
    {
        self::send($statusCode, [
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ]);
    }

    public static function error(string $message = 'Error', int $statusCode = 400, $errors = []): void
    {
        self::send($statusCode, [
            'status' => 'success',
            'message' => $message,
            'errors' => $errors
        ]);
    }

    /**
     * Send response
     * @param int $statusCode
     * @param array $payload
     * @return void
     */
    private static function send(int $statusCode, array $payload): void
    {
        if (ob_get_length()) {
            ob_clean();
        }

        header('Content-Type: application/json; charset=utf-8');
        http_response_code($statusCode);

        echo json_encode($payload, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
