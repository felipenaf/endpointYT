<?php

use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    /** @test */
    public function _404()
    {
        $route = new Route('/endpointYT/something?q=something');

        $this->assertEquals(
            404,
            $route->redirect('GET')[0]
        );
    }

}
