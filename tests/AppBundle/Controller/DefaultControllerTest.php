<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'http://'.$client->getContainer()->getParameter('host_front'));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
