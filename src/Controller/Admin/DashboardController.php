<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Entity\Theme;
use App\Entity\Tag;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $themes = $this->getDoctrine()->getRepository(Theme::class)->count([]);
        $comments = $this->getDoctrine()->getRepository(Comment::class)->count([]);

        return $this->render('admin/dashboard.html.twig', [
            'themes' => $themes,
            'comments' => $comments,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Thaimes');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoRoute('Dashboard', 'fa fa-home', 'admin');
        yield MenuItem::linktoRoute('Website', 'fa fa-map-marker', 'homepage');
        yield MenuItem::linkToCrud('Themes', 'fa fa-pen-fancy', Theme::class);
        yield MenuItem::linkToCrud('Comments', 'fa fa-comments', Comment::class);
        yield MenuItem::linkToCrud('Tags', 'fa fa-tag', Tag::class);
        // yield MenuItem::linkToCrud('The Label', 'icon class', EntityClass::class);
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)->addMenuItems([
            MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
        ]);
    }
}
