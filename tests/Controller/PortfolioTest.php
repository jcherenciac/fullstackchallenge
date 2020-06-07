<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase
{
    public function testCreateBuyOrderWithWrongPortfolioId()
    {
        $client = static::createClient();

        $body = [
            "id"=> 1,
            "portfolio"=> 10,
            "allocation" => 1,
            "shares" => 3
        ];

        $client->request( 'PUT', '/portfolio',[ 'body'=> $body] );

        $this->assertEquals(404, $client->getResponse()->getStatusCode());

    }

    // AÑADIMOS MAS TEST EN FUNCION DE LAS POSIBILIDADES DESCRITAS EN LAS FEATURES
}
