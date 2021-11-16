<?php

namespace App\Controller;

use App\Entity\Theme;
use App\Repository\CommentRepository;
use App\Repository\ThemeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ThemeController extends AbstractController
{
    private $twig;
    
    public function __construct(Environment $twig)
    {
    $this->twig = $twig;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index(ThemeRepository $themeRepository)
    {
        return new Response($this->twig->render('theme/index.html.twig', [
            'themes' => $themeRepository->findAll(),
        ]));
    }

    /**
     * @Route("/theme/{id}", name="theme")
     */
    public function show(Request $request, Theme $theme, CommentRepository $commentRepository)
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $commentRepository->getCommentPaginator($theme, $offset);

        return new Response($this->twig->render('theme/show.html.twig', [
            'theme' => $theme,
            'comments' => $paginator,
            'previous' => $offset - CommentRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + CommentRepository::PAGINATOR_PER_PAGE),
        ]));
    }
}
