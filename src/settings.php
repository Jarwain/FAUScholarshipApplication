<?php
$dbconfig = json_decode(file_get_contents(__DIR__ . '/../.config/database'));

return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'my_logger',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        // Database Settings
        'db' => [
            'host' => $dbconfig->host,
            'dbname' => $dbconfig->dbname,
            'user' => $dbconfig->user,
            'pass' => $dbconfig->pass,
        ]
    ],
];
