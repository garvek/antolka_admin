<?php

namespace App\Controller\Mapper;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use App\Repository\TileRepository;
use App\Repository\TileImageRepository;
use App\Repository\RegionRepository;
use App\Repository\ZoneRepository;

abstract class CartographerControllerBase extends AbstractDashboardController
{
    protected $tRepo;
    protected $iRepo;
    protected $rRepo;
    protected $zRepo;

    public function __construct(TileRepository $tRepo, TileImageRepository $iRepo,
        RegionRepository $rRepo, ZoneRepository $zRepo)
    {
        $this->tRepo = $tRepo;
        $this->iRepo = $iRepo;
        $this->rRepo = $rRepo;
        $this->zRepo = $zRepo;
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
        yield MenuItem::linkToUrl('Region', 'fas fa-list', $this->generateUrl('cartographer_region_index'));
        yield MenuItem::linkToUrl('Zone', 'fas fa-list', $this->generateUrl('cartographer_zone_index'));
        //yield MenuItem::linkToUrl('Terrain', 'fas fa-list', $this->generateUrl('cartographer_terrain_index'));
        //yield MenuItem::linkToUrl('Links', 'fas fa-list', $this->generateUrl('cartographer_links_index'));
        yield MenuItem::section();
        yield MenuItem::linkToLogout('Logout', 'fa fa-sign-out');
    }
}
