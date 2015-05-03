<?php
namespace tests\units\Foodtrack\Controller;

use mageekguy\atoum;

class FoodController extends atoum
{
    public function test___list___returnsAnArray()
    {
        $this
            ->given($this->newTestedInstance())
            ->then
            ->array($this->testedInstance->listAction());
    }
}
