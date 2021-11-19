<?php

namespace App\EventSubscriber;

use App\Repository\ThemeRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Twig\Environment;

class TwigEventSubscriber implements EventSubscriberInterface
{
    private $twig;
    private $themeRepository;

    public function __construct(Environment $twig, ThemeRepository $themeRepository)
    {
        $this->twig = $twig;
        $this->themeRepository = $themeRepository;
    }

    public function onControllerEvent(ControllerEvent $event)
    {
        $this->twig->addGlobal('themes', $this->themeRepository->findAll());
    }

    public static function getSubscribedEvents()
    {
        return [
            ControllerEvent::class => 'onControllerEvent',
        ];
    }
}
