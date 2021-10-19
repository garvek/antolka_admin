<?php

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use App\Entity\User;

/**
 * @Route("/main")
 */
class MainDashboardController extends AbstractDashboardController
{
    private $authorization;

    public function __construct(AuthorizationCheckerInterface $authorization)
    {
        $this->authorization = $authorization;
    }

    /**
     * @Route("/index", name="main_index")
     */
    public function index(): Response
    {
        // TODO: stats
        return $this->render('main-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setFaviconPath('images/antolka.png')
        ;
    }

    /**
     * @SuppressWarnings(PHPMD)
     */
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section();
        if ($this->authorization->isGranted(User::ROLE_PUBLISHER)) {
            yield MenuItem::linkToUrl('Message pages', 'fas fa-list', $this->generateUrl('message_index'));
        }
        if ($this->authorization->isGranted(User::ROLE_SUPERVISOR)) {
            yield MenuItem::linkToUrl('Editor pages', 'fas fa-list', $this->generateUrl('editor_index'));
            yield MenuItem::linkToUrl('Mapper pages', 'fas fa-list', $this->generateUrl('cartographer_index'));
        }
        if ($this->authorization->isGranted(User::ROLE_ADMIN)) {
            yield MenuItem::linkToUrl('CRUD pages', 'fas fa-list', $this->generateUrl('crud_index'));
        }
        yield MenuItem::section();
        yield MenuItem::linkToLogout('Logout', 'fa fa-sign-out');
    }
}
