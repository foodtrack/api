<?php
namespace tests\units\Foodtrack\Controller;

use tests\common\AbstractControllerTest;

class FoodController extends AbstractControllerTest
{
    public function getServiceName()
    {
        return 'foodtrack.foodcontroller';
    }

    public function test___listAction___returnsJson()
    {
        $this->object($this->listAction())
            ->isInstanceOf('Symfony\Component\HttpFoundation\JsonResponse');
    }

    public function test___listAction___returnsEmptyArray()
    {
        $content = json_decode($this->listAction()->getContent(), true);
        $this->array($content)->hasSize(0);
    }
}
