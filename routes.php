<?php

$getRoutes = [
    /**
     * Gets country by phone
     *
     * @param phone string
     *
     * @return string
     *
     * @example
     * get_phone_country?phone=+190560967404 -> MX(Мексика)
     */
    'get_phone_country' => [App\Controllers\PhoneController::class, 'getCountry'],

    /**
     * Search by phone start
     *
     * @param phone string
     *
     * @return array
     *
     * @example
     * search?phone=+7 -> [
     *   {
     *       "id": "1",
     *       "phone": "+7123123",
     *       "review_count": "2"
     *   },
     *   {
     *       "id": "3",
     *       "phone": "+7966",
     *       "review_count": "10"
     *   }
     * ]
     */
    'search' => [App\Controllers\PhoneController::class, 'search'],

    /**
     * Gets reviews by phone
     *
     * @param phone string
     *
     * @return array
     *
     * @example
     * review?phone=+7966 -> [
     *   {
     *       "id": "3",
     *       "phone": "+7966",
     *       "text": "23123123123",
     *       "user_id": "1",
     *       "rating": "1",
     *       "user_name": "123"
     *   },
     * ]
     */
    'review' => [App\Controllers\ReviewController::class, 'get'],
];

$postRoutes = [
    /**
     * Create review
     *
     * @param user_id ?int
     * @param phone string
     * @param text string
     *
     * @example
     * review?user_id=15&phone=+7966&text=23123123123
     */
    'review' => [App\Controllers\ReviewController::class, 'create'],

    /**
     * Rate review
     * Creates or updates rate review record
     *
     * @param review_id int
     * @param type enum(PLUS, MINUS)
     * @param user_id int
     *
     * @example
     * rate?review_id=3&type=PLUS&user_id=2
     */
    'rate' => [App\Controllers\UserController::class, 'rate'],

    /**
     * Create user
     *
     * @param name string
     *
     * @example
     * user?name=123
     */
    'user' => [App\Controllers\UserController::class, 'create'],
];
