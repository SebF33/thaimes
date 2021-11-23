<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Theme;
use App\Form\CommentFormType;
use App\Repository\CommentRepository;
use App\Repository\ThemeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ThemeController extends AbstractController
{
    private $twig;
    private $entityManager;
    
    public function __construct(Environment $twig, EntityManagerInterface $entityManager)
    {
        $this->twig = $twig;
        $this->entityManager = $entityManager;
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
     * @Route("/theme/{slug}", name="theme")
     */
    public function show(Request $request, Theme $theme, CommentRepository $commentRepository, ThemeRepository $themeRepository, string $photoDir)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setTheme($theme);
            if ($photo = $form['photo']->getData()) {
                $filename = bin2hex(random_bytes(6)).'.'.$photo->guessExtension();
                try {
                    $photo->move($photoDir, $filename);
                } catch (FileException $e) {
                    // unable to upload the photo, give up
                }
                $comment->setPhotoFilename($filename);
            }

            $this->entityManager->persist($comment);
            $this->entityManager->flush();

            return $this->redirectToRoute('theme', ['slug' => $theme->getSlug()]);
        }

        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $commentRepository->getCommentPaginator($theme, $offset);

        return new Response($this->twig->render('theme/show.html.twig', [
            'themes' => $themeRepository->findAll(),
            'theme' => $theme,
            'comments' => $paginator,
            'previous' => $offset - CommentRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + CommentRepository::PAGINATOR_PER_PAGE),
            'comment_form' => $form->createView(),
        ]));
    }
}
