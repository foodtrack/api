<?php
use Silex\Application;

global $app;
$app = require __DIR__ . '/../app/app.php';

if (!($app instanceof Application)) {
    die('Failed ton instanciate the application');
}
