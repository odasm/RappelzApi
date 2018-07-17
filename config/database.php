<?php

return [
    'fetch' => PDO::FETCH_OBJ,
    'default' => env('DB_CONNECTION', 'mysql'),
    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', '127.0.0.1'), // Provide IP address here
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'prefix' => '',
        ],
        'arcadiadb' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', '127.0.0.1'), // Provide IP address here
            'database' => env('DB_DATABASE_Arcadia', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'prefix' => '',
        ],
        'telecasterdb' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', '127.0.0.1'), // Provide IP address here
            'database' => env('DB_DATABASE_Telecaster', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'prefix' => '',
        ],
        'billingdb' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', '127.0.0.1'), // Provide IP address here
            'database' => env('DB_DATABASE_billing', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'prefix' => '',
        ],
    ],

    'migrations' => 'migrations',
    'redis' => [

        'cluster' => false,

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],

    ],

];
