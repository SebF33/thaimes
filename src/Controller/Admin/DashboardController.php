<?php

namespace App\Controller\Admin;


use App\Entity\Comment;
use App\Entity\Tag;
use App\Entity\Theme;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private CommentRepository $comments)
    {
        $this->comments = $comments;
    }

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

    private function diskSpace()
    {
        $bytes = disk_free_space("/");
        $precision = 2;
        $units = array('B', 'KiB', 'MiB', 'GiB', 'TiB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
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
     * @Route("/{_locale}/admin", name="admin")
     */
    public function index(): Response
    {
        $themes = $this->getDoctrine()->getRepository(Theme::class)->count([]);
        $comments = $this->getDoctrine()->getRepository(Comment::class)->count([]);
        $commentLast30Days = $this->commentLast30Days();
        $themesCounts = $this->themesCounts();
        $diskSpace = $this->diskSpace();

        return $this->render('admin/dashboard.html.twig', [
            'themes' => $themes,
            'comments' => $comments,
            'commentLast30Days' => $commentLast30Days,
            'commentLast30DaysSum' => array_sum($commentLast30Days),
            'themesCounts' => $themesCounts,
            'diskSpace' => $diskSpace
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Thaimes');
    }

    public function configureMenuItems(): iterable
    {
        $numPendingParticipations = $this->comments->getNumPendingReview();

        yield MenuItem::linktoRoute('Dashboard', 'fa fa-chart-line', 'admin');
        yield MenuItem::linktoRoute('Website', 'fa fa-map-marker', 'homepage');
        yield MenuItem::linkToCrud('Themes', 'fa fa-pen-fancy', Theme::class);
        yield MenuItem::linkToCrud('Participations', 'fa fa-comments', Comment::class)
            ->setBadge($numPendingParticipations);
        yield MenuItem::linkToCrud('Tags', 'fa fa-tag', Tag::class);
    }

    public function configureAssets(): Assets
    {
        return Assets::new()
            ->addCssFile('css/admin.css')
            ->addJsFile('https://cdn.jsdelivr.net/npm/apexcharts')
            ->addJsFile('js/area.js')
            ->addJsFile('js/donut.js');
    }

    /*
    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)->addMenuItems([
            MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
        ]);
    }
    */
}
