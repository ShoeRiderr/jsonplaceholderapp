<?php

namespace App\Tests;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class WebCustomTestCase extends WebTestCase
{
    const EMAIL = 'test@example.com';
    protected User $user;
    protected KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->findOneBy(['email' => self::EMAIL]) ?? new User;

        $user->setEmail(self::EMAIL);
        $user->setPassword('password');

        $userRepository->add($user, true);

        $this->user = $user;
    }
}