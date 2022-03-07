<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        // Créer 10 users
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $password = $this->passwordHasher->hashPassword($user, random_bytes(10));
            $user->setUsername('seb' . random_int(0, 1000));
            $user->setMail('test' . random_int(0, 1000) . '@test.fr');
            $user->setPassword($password);
            $user->setRoles(['ROLE_USER']);
            $user->setStatus(1);
            $user->setCreatedAt(new \DateTimeImmutable());
            $user->setUpdatedAt(new \DateTimeImmutable());

            $manager->persist($user);
            $manager->flush();
        }
    }
}
