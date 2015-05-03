<?php
use Silex\Application;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Helper\HelperSet;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;

// Create the application
$app = require __DIR__ . '/app.php';

if (!($app instanceof Application)) {
    die('Failed to instanciate the application');
}

// Set up Doctrine console
$console = new ConsoleApplication('Foodtrack');

$helperSet = new HelperSet(
    array(
        'db' => new ConnectionHelper($app['orm.em']->getConnection()),
        'em' => new EntityManagerHelper($app['orm.em']),
    )
);
$console->setHelperSet($helperSet);
ConsoleRunner::addCommands($console);

// Run 
$console->run();
