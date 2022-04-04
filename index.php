<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//автозагрузка классов
require_once './bootstrap.php';

//подключение роутов
require_once './routes.php';

//обработка исключений и ошибок по умолчанию через json
require_once './errors.php';

//auto wiring
$api_function = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))[1];
$routes = $_SERVER['REQUEST_METHOD'] == 'GET' ? $getRoutes : $postRoutes;
if (array_key_exists($api_function, $routes)) {
    $controller_method = new \ReflectionMethod($routes[$api_function][0], $routes[$api_function][1]);

    $is_db = count(array_filter($controller_method->getParameters(), function ($i) {
        return $i->name == 'db';
    }));

    if ($is_db) {
        $db = new App\Utils\Database();
        if ($_ENV['APP_DEBUG'] ?? "false" === "true")
            App\Utils\DatabaseSeeder::createTables($db);
        exit($controller_method->invoke(null, $db, new App\Utils\Request()));
    } else {
        exit($controller_method->invoke(null, new App\Utils\Request()));
    }
} else {
    exit(App\Utils\Response::json([
        'message' => 'Route not found'
    ], 404));
}
