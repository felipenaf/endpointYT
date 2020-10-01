<?php

use PHPUnit\Framework\TestCase;

class SearchTest extends TestCase
{
    /** @test */
    public function post405()
    {
        $search = new Search();

        $this->assertEquals([405], $search->getResponse('POST', 'search?q=something'));
    }

    /** @test */
    public function delete405()
    {
        $search = new Search();

        $this->assertEquals([405], $search->getResponse('DELETE', 'search?q=something'));
    }

    /** @test */
    public function put405()
    {
        $search = new Search();

        $this->assertEquals([405], $search->getResponse('PUT', 'search?q=something'));
    }

    /** @test */
    public function patch405()
    {
        $search = new Search();

        $this->assertEquals([405], $search->getResponse('PATCH', 'search?q=something'));
    }

    /** @test */
    public function wrongParameter()
    {
        $search = new Search();

        $this->assertEquals(
            [422, 'Os parâmetros ['. $search->getMandatoryParameters() .'] são obrigatórios.'],
            $search->getResponse('GET', 'search?something=something')
        );
    }

    /** @test */
    public function emptyParameter()
    {
        $search = new Search();

        $this->assertEquals(
            [422, 'O parâmetro "q" deve conter no mínimo três caracteres.'],
            $search->getResponse('GET', 'search?q=""')
        );
    }

    /** @test */
    public function success()
    {
        $search = new Search();

        $this->assertEquals(
            200,
            $search->getResponse('GET', 'search?q=something')[0]
        );
    }

    /** @test */
    public function keywordOneCharacter()
    {
        $search = new Search();

        $this->assertEquals(
            [422, 'O parâmetro "q" deve conter no mínimo três caracteres.'],
            $search->getResponse('GET', 'search?q=p')
        );
    }

    /** @test */
    public function keywordTwoCharacters()
    {
        $search = new Search();

        $this->assertEquals(
            [422, 'O parâmetro "q" deve conter no mínimo três caracteres.'],
            $search->getResponse('GET', 'search?q=ph')
        );
    }

}
