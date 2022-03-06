<?php

namespace App\DataFixtures;

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
        $theme1 = new Theme();
        $theme1->setTitle('Theme 1');
        $theme1->setYear('2019');
        $theme1->setDisplay(true);
        $manager->persist($theme1);

        $theme2 = new Theme();
        $theme2->setTitle('Theme 2');
        $theme2->setYear('2020');
        $theme2->setDisplay(false);
        $manager->persist($theme2);

        $comment1 = new Comment();
        $comment1->setTheme($theme1);
        $comment1->setAuthor('Mr X');
        $comment1->setEmail('mrx@example.com');
        $comment1->setText('This is a great theme.');
        $comment1->setState('published');
        $manager->persist($comment1);

        $comment2 = new Comment();
        $comment2->setTheme($theme2);
        $comment2->setAuthor('A Human');
        $comment2->setEmail('ahuman@example.com');
        $comment2->setText('I think this one is going to be moderated.');
        $manager->persist($comment2);

        $manager->flush();
    }
}
