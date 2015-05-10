<?php
use Silex\Provider\ServiceControllerServiceProvider;
use Foodtrack\Controller\FoodController;

$app->register(new ServiceControllerServiceProvider());
$app['food.controller'] = function () {
    return new FoodController();
};
