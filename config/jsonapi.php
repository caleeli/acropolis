<?php

return [
    'models' => [
        'App',
        'App\\Models',
    ],
    'cache_timeout_minutes' => floatval(env('API_CACHE_TIMEOUT', 0)), // in minutes
];
