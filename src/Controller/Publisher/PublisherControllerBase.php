<?php

namespace App\Controller\Publisher;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use App\Repository\MessageRepository;
use App\Repository\MessageRecipientRepository;

abstract class PublisherControllerBase extends AbstractDashboardController
{
    protected $mRepo;
    protected $rRepo;

    public function __construct(MessageRepository $mRepo, MessageRecipientRepository $rRepo)
    {
        $this->mRepo = $mRepo;
        $this->rRepo = $rRepo;
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
        yield MenuItem::linkToUrl('News', 'fas fa-list', $this->generateUrl('message_news_index'));
        yield MenuItem::linkToUrl('Region', 'fas fa-list', $this->generateUrl('message_inforegion_index'));
        yield MenuItem::linkToUrl('Zone', 'fas fa-list', $this->generateUrl('message_infozone_index'));
        yield MenuItem::linkToUrl('Event', 'fas fa-list', $this->generateUrl('message_event_index'));
        yield MenuItem::section();
        yield MenuItem::linkToLogout('Logout', 'fa fa-sign-out');
    }
}
