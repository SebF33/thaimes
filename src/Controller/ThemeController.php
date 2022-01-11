<?php

namespace App\Controller;

use App\Entity\Theme;
use App\Entity\Comment;
use App\Form\CommentFormType;
use App\Message\CommentMessage;
use App\Repository\TagRepository;
use App\Repository\ThemeRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Twig\Environment;

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
    public function index(Request $request, PaginatorInterface $paginator, ThemeRepository $themeRepository)
    {
        $data = $themeRepository->findRecentThemes();

        $themes = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            4
        );

        return new Response($this->twig->render('theme/index.html.twig', [
            'themes' => $themes
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
    public function showThemesByTag(Request $request, TagRepository $tagRepository)
    {
        $query = $request->attributes->get('name');

        $tag = $tagRepository->findOneBy(['name' => $query]);

        $themes = $tag->getThemes();

        return new Response($this->twig->render('theme/category.html.twig', [
            'themes' => $themes,
            'tag' => $tag,
        ]));
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/theme/{slug}", name="theme")
     */
    public function showTheme(Request $request, Theme $theme, CommentRepository $commentRepository, string $pictureDir)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setTheme($theme);
            if ($picture = $form['picture']->getData()) {
                $filename = bin2hex(random_bytes(6)) . '.' . $picture->guessExtension();
                try {
                    $picture->move($pictureDir, $filename);
                } catch (FileException $e) {
                    "Unable to upload the picture.";
                }
                $comment->setPictureFilename($filename);
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

        return new Response($this->twig->render('theme/showTheme.html.twig', [
            'theme' => $theme,
            'comments' =>  $commentRepository->findAllPublishedCommentsByTheme($theme),
            'comment_form' => $form->createView(),
        ]));
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/theme/{slug}/participations", name="participations")
     */
    public function showParticipationsByTheme(Request $request, Theme $theme, PaginatorInterface $paginator, CommentRepository $commentRepository)
    {
        $data = $commentRepository->findCommentsByTheme($theme);

        $comments = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            4
        );

        return new Response($this->twig->render('theme/showParticipations.html.twig', [
            'theme' => $theme,
            'comments' => $comments
        ]));
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/last-participations", name="last-participations")
     */
    public function showLastParticipations(Request $request, PaginatorInterface $paginator, CommentRepository $commentRepository)
    {
        $data = $commentRepository->findRecentComments();

        $comments = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            6
        );

        return new Response($this->twig->render('theme/lastParticipations.html.twig', [
            'comments' => $comments
        ]));
    }
}
