<?php
namespace tests\common;

use mageekguy\atoum;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractControllerTest extends atoum
{
    /**
     * Gets the application instance
     *
     * @return Silex\Application
     */
    public function getApp()
    {
        global $app;
        return $app;
    }

    /**
     * Fakes a request
     *
     * @param string $uri URI
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function request($uri)
    {
        return $this->getApp()->handle(Request::create($uri));
    }

    /**
     * Mocks a Doctrine repository
     *
     * @param string $entity      Entity class name
     * @param string $method      Method name to be mocked in the repository
     * @param mixed  $returnValue Value to be returned
     */
    public function mockRepository($entity, $method, $returnValue)
    {
        // Mock the repository
        $this->mockGenerator->orphanize('__construct');

        $repository = new \mock\Doctrine\ORM\EntityRepository();
        $repository->getMockController()->$method = function () use($returnValue) {
            return $returnValue;
        };

        // Mock the entity manager
        $em = new \mock\Doctrine\ORM\EntityManager();
        $em->getMockController()->getRepository = function () use ($repository) {
            return $repository;
        };

        $this->getApp()['orm.em'] = $em;
    }
}
