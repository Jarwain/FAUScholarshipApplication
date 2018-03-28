<?php

$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');

    $formatter = new \Monolog\Formatter\LineFormatter("[%datetime%] %channel%.%level_name%: %message% %context% %extra%\r\n");

    $file_handler = new \Monolog\Handler\StreamHandler('../logs/app.log');
    $file_handler->setFormatter($formatter);

    $logger->pushHandler($file_handler);
    return $logger;
};

$container['db'] = function ($c) {
    try{
        $db = $c['settings']['db'];
        $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'],
            $db['user'], $db['pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch (\PDOException $ex){
        $c->logger->addError($ex->getMessage());
    }
};

$container['sch'] = function ($c) {
    try {
        $controller = new ScholarshipController(__DIR__."/../assets/scholarship.json", $c->db);
        return $controller;
    } catch (Exception $e) {
        $c->logger->error($e->getMessage());
    }

};