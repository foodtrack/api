<?php
use Silex\Application;

// Set-up the global environment (PHP settings, library autoloading)
require_once __DIR__ . '/../vendor/autoload.php';

// Create an application
$app = new Application();

// Bootstrap the application
require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/config/services.php';
require_once __DIR__ . '/config/routing.php';

return $app;
