<?php

define('APP_ROOT', __DIR__ . '/../../');

return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'doctrine' => [
            // if true, metadata caching is forcefully disabled
            'dev_mode' => true,

            // path where the compiled metadata info will be cached
            // make sure the path exists and it is writable
            'cache_dir' => APP_ROOT . 'var/doctrine',

            // you should add any other path containing annotated entity classes
            'metadata_dirs' => [__DIR__ . '/../Entity', __DIR__ . '/../maps/'],

            'xml_maps' => __DIR__ . '/../maps/',

            'connection' => [
                'driver' => 'pdo_mysql',
                'host' => 'localhost',
                'unix_socket' => '/Applications/MAMP/tmp/mysql/mysql.sock',
                'port' => 8889, // 3306
                'dbname' => 'voucher_pool',
                'user' => 'root',
                'password' => 'root',
                'charset' => 'utf8'
            ]
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
    ],
];
