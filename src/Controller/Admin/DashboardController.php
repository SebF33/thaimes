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
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Theme');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoRoute('Back to the website', 'fa fa-home', 'homepage');
        yield MenuItem::linkToCrud('Themes', 'fa fa-map-marker', Theme::class);
        yield MenuItem::linkToCrud('Comments', 'fa fa-comments', Comment::class);
        yield MenuItem::linkToCrud('Tags', 'fas fa-tag', Tag::class);
        // yield MenuItem::linkToCrud('The Label', 'icon class', EntityClass::class);
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)->addMenuItems([
            MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
        ]);
    }
}