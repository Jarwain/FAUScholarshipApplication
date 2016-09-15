<?php

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $file = __DIR__ . $_SERVER['REQUEST_URI'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/messageResponse.php';
require __DIR__ . '/../src/genException.php';
require __DIR__ . '/../src/database.php';


session_start();

try{
// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);


// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';


// autoload
spl_autoload_register(function ($className){
	if (file_exists(__DIR__ . '/../src/models/' . $className . '.php')) { 
		require_once __DIR__ . '/../src/models/' . $className . '.php';
		return true; 
	}
	return false;
});

// Run app
$app->run();

} catch (Exception $e){
	$container->log->error("Exception: ". $e->getMessage());
}