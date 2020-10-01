<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class SearchTest extends TestCase
{
    /** @test */
    public function _405()
    {
        $search = new Search('search?q=something');

        $this->assertEquals(405, $search->getResponse('GET'));
    }
}
