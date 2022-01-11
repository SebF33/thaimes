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
        $form = $this->createFormBuilder('SymfonyComponentFormExtensionCoreTypeFormType', array('csrf_protection' => false))
            ->setAction($this->generateUrl('themes_search_result'))
            ->setMethod('GET')
            ->getForm();

        return $this->render('search/searchBar.html.twig', [
            'searchForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/themes_search_result", name="themes_search_result")
     * @param Request $request
     */
    public function themesSearch(Request $request, PaginatorInterface $paginator, ThemeRepository $themeRepository)
    {

        $query = $request->query->get('searchForm')['query'];
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
