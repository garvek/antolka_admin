<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Adventurer;
use App\Entity\AdventurerAttribute;
use App\Entity\ControlInfo;
use App\Entity\Message;
use App\Entity\MessageRecipient;
use App\Entity\Region;
use App\Entity\Tile;
use App\Entity\TileImage;
use App\Entity\User;
use App\Entity\Vehicle;
use App\Entity\VehiclePassenger;
use App\Entity\Zone;

/**
 * @Route("/admin/crud")
 */
class CrudDashboardController extends AbstractDashboardController
{
    /**
     * @Route("/", name="crud_index")
     */
    public function index(): Response
    {
        /** @var AdminUrlGenerator */
        $routeBuilder = $this->get(AdminUrlGenerator::class);
        return $this->redirect($routeBuilder->setController(UserCrudController::class)->generateUrl());
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
        yield MenuItem::linkToUrl('Return to index', 'fa fa-home', $this->generateUrl('main_index'));
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section();
        yield MenuItem::linkToCrud('User', 'fas fa-list', User::class);
        yield MenuItem::linkToCrud('ControlInfo', 'fas fa-list', ControlInfo::class);
        yield MenuItem::section();
        yield MenuItem::linkToCrud('Adventurer', 'fas fa-list', Adventurer::class);
        yield MenuItem::linkToCrud('AdventurerAttribute', 'fas fa-list', AdventurerAttribute::class);
        yield MenuItem::linkToCrud('Vehicle', 'fas fa-list', Vehicle::class);
        yield MenuItem::linkToCrud('VehiclePassenger', 'fas fa-list', VehiclePassenger::class);
        yield MenuItem::section();
        yield MenuItem::linkToCrud('Region', 'fas fa-list', Region::class);
        yield MenuItem::linkToCrud('Zone', 'fas fa-list', Zone::class);
        yield MenuItem::linkToCrud('Tile', 'fas fa-list', Tile::class);
        yield MenuItem::linkToCrud('TileImage', 'fas fa-list', TileImage::class);
        yield MenuItem::section();
        yield MenuItem::linkToCrud('Message', 'fas fa-list', Message::class);
        yield MenuItem::linkToCrud('MessageRecipient', 'fas fa-list', MessageRecipient::class);
        yield MenuItem::section();
        yield MenuItem::linkToLogout('Logout', 'fa fa-sign-out');
    }
}
