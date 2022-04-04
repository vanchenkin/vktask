<?php

$getRoutes = [
    'get_phone_country' => [App\Controllers\PhoneController::class, 'getCountry'],
    'search' => [App\Controllers\PhoneController::class, 'search'],
    'review' => [App\Controllers\ReviewController::class, 'get'],
];

$postRoutes = [
    'review' => [App\Controllers\ReviewController::class, 'create'],
    'rate' => [App\Controllers\UserController::class, 'rate'],
    'user' => [App\Controllers\UserController::class, 'create'],
];