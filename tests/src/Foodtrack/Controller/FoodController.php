<?php
namespace tests\units\Foodtrack\Controller;

use tests\common\AbstractControllerTest;
use Foodtrack\Entity\Food;
use Doctrine\ORM\EntityManager;

class FoodController extends AbstractControllerTest
{
    public function test___list___returnsJsonData()
    {
        $this->object($this->request('/food/'))->isInstanceOf('Symfony\Component\HttpFoundation\JsonResponse');
    }

    public function test___list___returnsA200()
    {
        $this->integer($this->request('/food/')->getStatusCode())->isEqualTo(200);
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
        $this->array(json_decode($this->request('/food/')->getContent(), true))->isIdenticalTo($expected['raw']);
    }

    public function test___search___returnsJsonData()
    {
        $this->object($this->request('/food/foo'))->isInstanceOf('Symfony\Component\HttpFoundation\JsonResponse');
    }

    public function test___search___givenValidName___returns200()
    {
        $this->mockRepository('Foodtrack\Entity\Food', 'findOneByName', new Food());
        $this->integer($this->request('/food/foo')->getStatusCode())->isEqualTo(200);
    }

    public function test___search___givenValidName___returnsFood()
    {
        // Test data
        $data = $this->generateFood();

        // Actual test
        $this->mockRepository('Foodtrack\Entity\Food', 'findOneByName', $data);
        $this->array(json_decode($this->request('/food/foo')->getContent(), true))->isIdenticalTo($data->toArray());
    }

    public function test___search___givenInvalidName___returns404()
    {
        $this->mockRepository('Foodtrack\Entity\Food', 'findOneByName', null);
        $this->integer($this->request('/food/bar')->getStatusCode())->isEqualTo(404);
    }

    public function test___search___givenInvalidName___returnsError()
    {
        $this->mockRepository('Foodtrack\Entity\Food', 'findOneByName', null);
        $this->array(json_decode($this->request('/food/bar')->getContent(), true))->isIdenticalTo(
            array(
                'error' => 'Food named `bar` does not exist'
            )
        );
    }

    protected function generateFood()
    {
        $entity = new Food();
        $entity->setName(uniqid());
        $entity->setCalories(rand());

        return $entity;
    }
}
