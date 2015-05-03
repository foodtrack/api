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

    public function test___listAction___returnsJson()
    {
        $this->object($this->listAction())
            ->isInstanceOf('Symfony\Component\HttpFoundation\JsonResponse');
    }

    public function test___listAction___returnsFoodList()
    {
        // Generate test data
        $data = array(
            'expected' => array(),
            'entities' => array(),
        );

        for ($i = 0; $i < 3; $i++) {
            $expected = array('name' => uniqid(), 'calories' => rand());

            $entity = new Food();
            $entity->setName($expected['name']);
            $entity->setCalories($expected['calories']);

            $data['expected'][] = $expected;
            $data['entities'][] = $entity;
        }

        // Mock the repository
        $this->mockGenerator->orphanize('__construct');

        $repository = new \mock\Doctrine\ORM\EntityRepository();
        $repository->getMockController()->findAll = function () use($data) {
            return $data['entities'];
        };

        // Mock the entity manager
        $em = new \mock\Doctrine\ORM\EntityManager();
        $em->getMockController()->getRepository = function () use ($repository) {
            return $repository;
        };

        $this->setEntityManager($em);

        // Make the actual test
        $response = json_decode($this->listAction()->getContent(), true);
        $this->array($response)->isIdenticalTo($data['expected']);
    }
}
