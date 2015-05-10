<?php
namespace tests\units\Foodtrack\Controller;

use mageekguy\atoum;
use Symfony\Component\HttpFoundation\Request;

class FoodController extends atoum
{
    public function test___list___returnsAnArray()
    {
        $this
            ->given($response = $this->get('/food'))
            ->then
            ->object($response)
                ->isInstanceOf('Symfony\Component\HttpFoundation\JsonResponse');
    }

    public function get($uri)
    {
        return getApp()->handle(Request::create($uri));
    }
}
