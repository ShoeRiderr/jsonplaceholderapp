<?php

namespace App\Tests\Controller;

use App\Tests\WebCustomTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends WebCustomTestCase
{
    public function testShowPostListSuccessfully(): void
    {
        $this->client->loginUser($this->user);
        $this->client->request('GET', '/lista');

        $this->assertResponseIsSuccessful();
    }

    public function testShowPostListAsGuestUser(): void
    {
        $this->client->request('GET', '/lista');

        $this->assertResponseRedirects();
    }
}
