<?php

namespace App\Controller;

use App\Repository\ThemeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;

class SearchController extends AbstractController
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/search", name="search")
     */
    public function index(): Response
    {
        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }

    public function searchBar()
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('themes-search'))
            ->getForm();

        return $this->render('search/searchBar.html.twig', [
            'searchForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/themes-search", name="themes-search")
     * @param Request $request
     */
    public function themesSearch(Request $request, PaginatorInterface $paginator, ThemeRepository $themeRepository)
    {
        $query = $request->request->get('searchForm')['query'];
        $data = $themeRepository->findThemesByTitle($query);

        $themes = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            2
        );

        return new Response($this->twig->render('search/results.html.twig', [
            'themes' => $themes
        ]));
    }
}
