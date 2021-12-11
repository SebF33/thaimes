<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\Theme;
use Twig\Environment;
use App\Entity\Comment;
use App\Form\CommentFormType;
use App\Message\CommentMessage;
use App\Repository\TagRepository;
use App\Repository\ThemeRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ThemeController extends AbstractController
{
    private $twig;
    private $entityManager;
    private $bus;

    public function __construct(Environment $twig, EntityManagerInterface $entityManager, MessageBusInterface $bus)
    {
        $this->twig = $twig;
        $this->entityManager = $entityManager;
        $this->bus = $bus;
    }

    /**
     * @Route("/")
     */
    public function indexNoLocale()
    {
        return $this->redirectToRoute('homepage', ['_locale' => 'en']);
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/", name="homepage")
     */
    public function index(ThemeRepository $themeRepository)
    {
        return new Response($this->twig->render('theme/index.html.twig', [
            'themes' => $themeRepository->findAllDisplayThemes(),
        ]));
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/categories", name="categories")
     */
    public function showTagList(TagRepository $tagRepository)
    {
        return new Response($this->twig->render('theme/categories.html.twig', [
            'tags_by_letter' => $tagRepository->findAllByTagLetter(),
        ]));
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/category/{name}", name="category")
     */
    public function showThemeByCategory(Request $request, ThemeRepository $themeRepository)
    {
        $request->attributes->get('name');
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository(Tag::class)->findBy(array('name' => $request));

        return new Response($this->twig->render('theme/category.html.twig', [
            'themes' => $category->getTheme(),
        ]));
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/theme/{slug}", name="theme")
     */
    public function show(Request $request, Theme $theme, CommentRepository $commentRepository, ThemeRepository $themeRepository, string $photoDir)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setTheme($theme);
            if ($photo = $form['photo']->getData()) {
                $filename = bin2hex(random_bytes(6)) . '.' . $photo->guessExtension();
                try {
                    $photo->move($photoDir, $filename);
                } catch (FileException $e) {
                    "Unable to upload the photo.";
                }
                $comment->setPhotoFilename($filename);
            }

            $this->entityManager->persist($comment);
            $this->entityManager->flush();

            $context = [
                'user_ip' => $request->getClientIp(),
                'user_agent' => $request->headers->get('user-agent'),
                'referrer' => $request->headers->get('referer'),
                'permalink' => $request->getUri(),
            ];

            $this->bus->dispatch(new CommentMessage($comment->getId(), $context));

            return $this->redirectToRoute('theme', ['slug' => $theme->getSlug()]);
        }

        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $commentRepository->getCommentPaginator($theme, $offset);

        return new Response($this->twig->render('theme/showComments.html.twig', [
            'themes' => $themeRepository->findAllDisplayThemes(),
            'theme' => $theme,
            'comments' => $paginator,
            'previous' => $offset - CommentRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + CommentRepository::PAGINATOR_PER_PAGE),
            'comment_form' => $form->createView(),
        ]));
    }
}
