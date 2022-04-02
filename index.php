<?php
require 'vendor/autoload.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

set_exception_handler(function (Throwable $e) {
    http_response_code($e->getCode());
    $error_array = [
        'error' => true,
        'code' => $e->getCode(),
    ];

    if ($_ENV['APP_DEBUG'] === "true")
        $error_array = [
            'error' => true,
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
            'trace' => $e->getTraceAsString(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ];
    echo json_encode($error_array);
});

$request = new App\Utils\Request($_SERVER["REQUEST_METHOD"], $_SERVER['REQUEST_URI']);
$api_function = $request->getUri()[1];

require 'routes.php';

if (array_key_exists($api_function, $routes)) {
    $method = new ReflectionMethod($routes[$api_function][0], $routes[$api_function][1]);

    $is_need_db = count(array_filter($method->getParameters(), function ($x) {
        return $x->name == 'db';
    }));

    if ($is_need_db) {
        $db = new App\Utils\Database();
        $method->invoke(null, $db, $request);
    } else {
        $method->invoke(null, $request);
    }
} else {
    throw new Exception('Route not found', 404);
}


//uncomment if you need to create tables
//App\Utils\DatabaseSeeder::createTables($db);