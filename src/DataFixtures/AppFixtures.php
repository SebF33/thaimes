<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Comment;
use App\Entity\Theme;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class AppFixtures extends Fixture
{
    private $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function load(ObjectManager $manager): void
    {
        $amsterdam = new Theme();
        $amsterdam->setTitle('Amsterdam');
        $amsterdam->setYear('2019');
        $amsterdam->setDisplay(true);
        $manager->persist($amsterdam);

        $paris = new Theme();
        $paris->setTitle('Paris');
        $paris->setYear('2020');
        $paris->setDisplay(false);
        $manager->persist($paris);

        $comment1 = new Comment();
        $comment1->setTheme($amsterdam);
        $comment1->setAuthor('Fabien');
        $comment1->setEmail('fabien@example.com');
        $comment1->setText('This was a great conference.');
        $comment1->setState('published');
        $manager->persist($comment1);

        $comment2 = new Comment();
        $comment2->setTheme($amsterdam);
        $comment2->setAuthor('Lucas');
        $comment2->setEmail('lucas@example.com');
        $comment2->setText('I think this one is going to be moderated.');
        $manager->persist($comment2);

        $manager->flush();
    }
}
