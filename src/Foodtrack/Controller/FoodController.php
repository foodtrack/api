<?php
namespace Foodtrack\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class FoodController
{
    public function listAction()
    {
        return new JsonResponse(array());
    }
}
