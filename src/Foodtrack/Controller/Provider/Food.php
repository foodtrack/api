<?php
namespace Foodtrack\Controller\Provider;

use Silex\ControllerProviderInterface;
use Silex\ServiceProviderInterface;
use Silex\Application;
use Foodtrack\Controller\FoodController;

class Food implements ControllerProviderInterface, ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['foodtrack.foodcontroller'] = $app->share(function () use($app) {
            return new FoodController($app['orm.em']);
        });
    }

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        $controllers->get('/list', 'foodtrack.foodcontroller:listAction');
        return $controllers;
    }

    public function boot(Application $app) {}
}
