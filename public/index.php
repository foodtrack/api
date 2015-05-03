<?php
use Silex\Application;

// Create an application
$app = require __DIR__ . '/../app/app.php';

if (!($app instanceof Application)) {
    die('Failed to instanciate the application');
}

// Run!
$app->run();
