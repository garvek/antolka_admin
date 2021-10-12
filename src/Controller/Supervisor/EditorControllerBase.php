<?php

namespace App\Controller\Supervisor;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

abstract class EditorControllerBase extends AbstractDashboardController
{
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
        yield MenuItem::linktoUrl('Dashboard', 'fa fa-home', $this->generateUrl('editor_index'));
        yield MenuItem::section();
        yield MenuItem::linktoUrl('Adventurer (AI)', 'fas fa-list', $this->generateUrl('editor_adventurer_index'));
        yield MenuItem::linktoUrl('Adventurer (GM)', 'fas fa-list', $this->generateUrl('editor_adventurer_pawns'));
        yield MenuItem::section();
        yield MenuItem::linktoUrl('Control', 'fas fa-list', $this->generateUrl('editor_control_index'));
        yield MenuItem::section();
        yield MenuItem::linkToLogout('Logout', 'fa fa-sign-out');
    }
}
