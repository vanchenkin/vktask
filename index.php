<?php
require_once './bootstrap.php';
require_once './routes.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//обработка исключений через json
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
    echo json_encode($error_array, JSON_UNESCAPED_UNICODE);
});

//вызов метода по пути
$api_function = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))[1];
$routes = $_SERVER['REQUEST_METHOD'] == 'GET' ? $getRoutes : $postRoutes;
if (array_key_exists($api_function, $routes)) {
    $controller_method = new \ReflectionMethod($routes[$api_function][0], $routes[$api_function][1]);

    $is_db = count(array_filter($controller_method->getParameters(), function ($i) {
        return $i->name == 'db';
    }));

    if ($is_db) {
        $db = new App\Utils\Database();

        //в production убрать
        App\Utils\DatabaseSeeder::createTables($db);
        //

        exit($controller_method->invoke(null, $db, new App\Utils\Request()));
    } else {
        exit($controller_method->invoke(null, new App\Utils\Request()));
    }
} else {
    throw new Exception('Route not found', 404);
}
