<?php

namespace App\EntityListener;

use App\Entity\Theme;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;


class ThemeEntityListener
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function prePersist(Theme $theme, LifecycleEventArgs $event)
    {
        $theme->computeSlug($this->slugger);
    }

    public function preUpdate(Theme $theme, LifecycleEventArgs $event)
    {
        $theme->computeSlug($this->slugger);
    }
}
