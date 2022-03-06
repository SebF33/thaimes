<?php

namespace App\Controller;

use App\Entity\GroupConversation;
use App\Entity\User;
use App\Form\GroupConversationFormType;
use App\Repository\GroupConversationRepository;
use App\Repository\UserRepository;
use App\Service\CookieGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class GroupConversationController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;
    /**
     * @var Security
     */
    private Security $security;

    public function __construct(UserRepository $userRepository, Security $security)
    {
        $this->userRepository = $userRepository;
        $this->security       = $security;
    }

    /**
     * Afficher la liste des conversations
     *
     * @Route("/{_locale<%app.supported_locales%>}/conversation_browse", name="conversation_browse")
     * @param GroupConversationRepository $groupConversationRepository
     * @return Response
     */
    public function browse(GroupConversationRepository $groupConversationRepository, ?CookieGenerator $cookieGenerator): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $conversations = $groupConversationRepository->findAll();
        $cookie        =  $cookieGenerator->generate();

        $page = 'chat';
        $response = $this->render('conversation/browse.html.twig', [
            'page' => $page,
            'conversations' => $conversations,
            'jwt'           => $cookie->getValue()
        ]);

        //fix CORS policy
        //$response->headers->set("Access-Control-Allow-Origin", '*');
        //generate cookie for connected user
        $response->headers->setCookie($cookie);

        return $response;
    }

    /**
     * Créer un nouveau groupe de conversation
     *
     * @Route("/{_locale<%app.supported_locales%>}/conversation/add", name="conversation_add")
     */
    public function add(Request $request, ValidatorInterface $validator): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        //used with connected user
        /** @var User $user */
        $user = $this->security->getUser();
        if (!($user)) {
            $this->addFlash('error', 'Utilisateur créateur du groupe incorrect.');
            return $this->redirectToRoute('app_login');
        }

        $conversation = new GroupConversation();

        $form = $this->createForm(GroupConversationFormType::class, $conversation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $conversation->setCreated(new \DateTime('now'));
            $conversation->setUpdated(new \DateTime('now'));
            $conversation->setAdmin($user);

            //@TODO: I don't understand why users are not saved with ManyToMany connexion (table user_group_conversation)
            $user->addConversation($conversation);
            if ($conversation->getUsers()) {
                foreach ($conversation->getUsers() as $user) {
                    $user->addConversation($conversation);
                }
            }

            $errors = $validator->validate($conversation);
            if (count($errors) > 0) {
                return new Response((string) $errors, 400);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($conversation);
            $em->flush();

            return $this->redirectToRoute('conversation_browse');
        }

        $page = 'chat';
        return $this->renderForm('conversation/_form/add.html.twig', [
            'page' => $page,
            'form' => $form
        ]);
    }

    /**
     * Supprimer le groupe de conversation
     *
     * @Route("/conversation/{id}/delete", name="conversation_delete", requirements={"id" : "\d+"})
     */
    public function delete(GroupConversation $groupConversation): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
    }
}
