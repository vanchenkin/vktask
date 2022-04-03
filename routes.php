<?php

$getRoutes = [
    'get_phone_country' => [App\Controllers\PhoneController::class, 'getCountry'],
    'search_phone' => [App\Controllers\PhoneController::class, 'search'],
    'review' => [App\Controllers\ReviewController::class, 'create'], //post
];

$postRoutes = [
    'review' => [App\Controllers\ReviewController::class, 'create'],
];