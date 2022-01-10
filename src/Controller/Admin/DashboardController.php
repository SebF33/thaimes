<?php

namespace App\Controller\Admin;

use App\Entity\Tag;
use App\Entity\Theme;
use App\Entity\Comment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    private function commentLast30Days()
    {
        $result = [];
        $days = '30';
        $begin = new \DateTime('-' . $days . ' day');
        $end = new \DateTime();
        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($begin, $interval, $end);

        $commentLast30Days = $this->getDoctrine()->getRepository(Comment::class)->getCommentLastDays();

        foreach ($period as $dt) {
            $result[$dt->format("Y-m-d")] = 0;
        }
        foreach ($commentLast30Days as $commentLast30Day) {
            $result[$commentLast30Day['d']] = $commentLast30Day['num'];
        }

        ksort($result);

        return $result;
    }

    private function themesCounts()
    {
        $result = [];

        $themesCounts = $this->getDoctrine()->getRepository(Tag::class)->getThemesCounts();

        foreach ($themesCounts as $themesCount) {
            $result[$themesCount['name']] = $themesCount['counter'];
        }

        ksort($result);

        return $result;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $themes = $this->getDoctrine()->getRepository(Theme::class)->count([]);
        $comments = $this->getDoctrine()->getRepository(Comment::class)->count([]);
        $commentLast30Days = $this->commentLast30Days();
        $themesCounts = $this->themesCounts();

        return $this->render('admin/dashboard.html.twig', [
            'themes' => $themes,
            'comments' => $comments,
            'commentLast30Days' => $commentLast30Days,
            'commentLast30DaysSum' => array_sum($commentLast30Days),
            'themesCounts' => $themesCounts,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Thaimes');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoRoute('Dashboard', 'fa fa-chart-line', 'admin');
        yield MenuItem::linktoRoute('Website', 'fa fa-map-marker', 'homepage');
        yield MenuItem::linkToCrud('Themes', 'fa fa-pen-fancy', Theme::class);
        yield MenuItem::linkToCrud('Participations', 'fa fa-comments', Comment::class);
        yield MenuItem::linkToCrud('Tags', 'fa fa-tag', Tag::class);
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)->addMenuItems([
            MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
        ]);
    }

    public function configureAssets(): Assets
    {
        return Assets::new()
            ->addCssFile('css/admin.css')
            ->addJsFile('https://cdn.jsdelivr.net/npm/apexcharts')
            ->addJsFile('js/area.js')
            ->addJsFile('js/donut.js');
    }
}
