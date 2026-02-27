<?php 

return [
    'admin_only_mode' => env('ADMIN_ONLY_MODE', false),
    'allowed_routes' => [
        'auth', 'login', 'logout'
    ],
];