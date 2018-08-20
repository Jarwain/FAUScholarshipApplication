<?php
$config = json_decode(file_get_contents(__DIR__ . '/../config.json'));

return [
    'settings' => [
        'templateVars' => (array)$config->template,
        'displayErrorDetails' => !$config->isProduction, // set to false in production
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
            'host' => $config->db->host,
            'dbname' => $config->db->dbname,
            'user' => $config->db->user,
            'pass' => $config->db->pass,
        ]
    ],
];
