<?php
namespace Foodtrack\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManager;

class FoodController
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->setEntityManager($em);
    }

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
        return $this;
    }

    public function listAction()
    {
        $entities = $this->em->getRepository('Foodtrack\Entity\Food')->findAll();
        $response = array();
        foreach ($entities as $entity) {
            $response[] = array(
                'name' => $entity->getName(),
                'calories' => $entity->getCalories(),
            );
        }

        return new JsonResponse($response);
    }

    public function searchAction($name)
    {
        $food = $this->em->getRepository('Foodtrack\Entity\Food')->findOneByName($name);
        if ($food === null) {
            return new JsonResponse(
                array(
                    'error' => sprintf('Food named `%s` does not exist', $name)
                ),
                404
            );
        }

        return new JsonResponse($food->toArray());
    }
}
