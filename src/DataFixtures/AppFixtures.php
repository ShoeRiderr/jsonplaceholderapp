<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher
    )
    {}

    public function load(ObjectManager $manager): void
    {
        $user1 = new User();
        $user1->setEmail('test1@example.com');
        $user1->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user1,
                'password'
            )
        );
        $user2 = new User();
        $user2->setEmail('test2@example.com');
        $user2->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user2,
                'password'
            )
        );

        $manager->persist($user1);
        $manager->persist($user2);

        $post1 = new Post();
        $post1->setTitle('test1');
        $post1->setAuthorName('test1');
        $post1->setBody('test2');

        $post2 = new Post();
        $post2->setTitle('test1');
        $post2->setAuthorName('test2');
        $post2->setBody('test2');

        $manager->persist($post1);
        $manager->persist($post2);

        $manager->flush();
    }
}
