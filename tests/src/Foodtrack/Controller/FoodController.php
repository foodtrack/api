<?php
namespace tests\units\Foodtrack\Controller;

use tests\common\AbstractControllerTest;
use Foodtrack\Entity\Food;
use Doctrine\ORM\EntityManager;

class FoodController extends AbstractControllerTest
{
    public function getServiceName()
    {
        return 'foodtrack.foodcontroller';
    }

    public function test___list___returnsJsonData()
    {
        $this->object($this->listAction())->isInstanceOf('Symfony\Component\HttpFoundation\JsonResponse');
    }

    public function test___list___returnsA200()
    {
        $this->integer($this->listAction()->getStatusCode())->isEqualTo(200);
    }

    public function test___list___returnsAllFood()
    {
        // Test data
        $expected = array(
            'raw'      => array(),
            'entities' => array(),
        );

        for ($i = 0; $i < 3; $i++) {
            $data = $this->generateFood();
            $expected['entities'][] = $data;
            $expected['raw'][] = $data->toArray();
        }

        // Actual test
        $this->mockRepository('Foodtrack\Entity\Food', 'findAll', $expected['entities']);
        $this->array(json_decode($this->listAction()->getContent(), true))->isIdenticalTo($expected['raw']);
    }

    protected function generateFood()
    {
        $entity = new Food();
        $entity->setName(uniqid());
        $entity->setCalories(rand());

        return $entity;
    }
}
