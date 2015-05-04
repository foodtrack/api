<?php
namespace tests\common;

use mageekguy\atoum;

abstract class AbstractControllerTest extends atoum
{
    /**
     * Returns the name of the controller service name
     *
     * @return string
     */
    abstract public function getServiceName();

    /**
     * Gets an instance for tested controller
     *
     * @return mixed
     */
    public function getTestedInstance()
    {
        return $this->getApp()[$this->getServiceName()];
    }

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

        $this->setEntityManager($em);
    }

    /**
     * Shortcut for accessing the application instance
     *
     * {@inheritdoc}
     */
    public function __get($name)
    {
        if ($name === 'app') {
            return $this->getApp();
        }

        return parent::__get($name);
    }

    /**
     * Shortcut for calling a method of the tested instance
     *
     * @param string $method    Method name
     * @param array  $arguments Method arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $testedInstance = $this->getTestedInstance();
        if (method_exists($testedInstance, $name)) {
            return call_user_func_array(array($testedInstance, $name), $arguments);
        }

        return parent::__call($name, $arguments);
    }
}
