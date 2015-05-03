<?php
use Foodtrack\Controller\Provider\Food as FoodProvider;

// Food controller
$foodProvider = new FoodProvider();
$app->register($foodProvider);
$app->mount('/food/', $foodProvider);
