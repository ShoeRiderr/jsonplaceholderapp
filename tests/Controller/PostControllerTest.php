<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase
{
    public function testShowPostListSuccessfully(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/lista');

        $this->assertResponseIsSuccessful();
    }
}
