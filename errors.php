<?php

set_exception_handler(function (\Throwable $e) {
    http_response_code(500);
    $error_array = [
        'error' => true,
        'code' => 500,
    ];

    if ($_ENV['APP_DEBUG'] ?? "false" === "true") {
        $error_array = [
            'error' => true,
            'code' => 500,
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ];
    }
    echo json_encode($error_array, JSON_UNESCAPED_UNICODE);
});

set_error_handler(function ($errno, $errstr, $errfile, $errline, $errcontext) {
    http_response_code(500);
    $error_array = [
        'error' => true,
        'code' => 500,
    ];

    if ($_ENV['APP_DEBUG'] ?? "false" === "true") {
        $error_array = [
            'error' => true,
            'code' => 500,
            'message' => $errstr,
            'file' => $errfile,
            'line' => $errline,
        ];
    }
    echo json_encode($error_array, JSON_UNESCAPED_UNICODE);
});
