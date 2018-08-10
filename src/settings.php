<?php
$isProduction = False;
$dbconfig = json_decode(file_get_contents(__DIR__ . '/settings.json'));
/*
settings.json example
{
    "host": "localhost",
    "dbname": "dbname",
    "user": "username",
    "pass": "pass"
}
 */

return [
    'settings' => [
        'templateVars' => [
            'baseUrl' => 'scholarship',
            'title' => 'Office of Financial Aid',
            'scholarship_year' => '2019-2020'
        ],

        'displayErrorDetails' => !$isProduction, // set to false in production
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
