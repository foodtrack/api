<?php
use Silex\Provider\ServiceControllerServiceProvider;
use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Silex\Provider\DoctrineServiceProvider;

$app->register(new ServiceControllerServiceProvider());

$app->register(
    new DoctrineServiceProvider(),
    array(
        'db.options' => array (
            'driver'    => 'pdo_mysql',
            'host'      => 'localhost',
            'dbname'    => 'foodtrack',
            'user'      => 'root',
            'password'  => '',
            'charset'   => 'utf8',
        ),
    )
);

$app->register(
    new DoctrineOrmServiceProvider(),
    array(
        'orm.proxies_dir' => __DIR__ . '/../cache/proxies',
        'orm.em.options' => array(
            'mappings' => array(
                array(
                    'type' => 'annotation',
                    'namespace' => 'Foodtrack\Entity',
                    'path' => __DIR__ . '/../../src/Foodtrack/Entity',
                ),
            ),
        ),
    )
);
