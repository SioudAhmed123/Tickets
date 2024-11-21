<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Entity\User;
use App\Entity\Tickets;
use App\Entity\Events;
use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Router\Source;
use phpDocumentor\Reflection\PseudoTypes\True_;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(TicketsCrudController::class)->generateUrl());

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        
        yield MenuItem::linkToCrud('Tickets', 'fas fa-users', Tickets::class);
        yield MenuItem::linkToCrud('Events', 'fas fa-events', Events::class);
        yield MenuItem::linkToCrud('Category', 'fas fa-category', Categorie::class);
        yield MenuItem::linkToCrud('Reservation', 'fas fa-reservation', Reservation::class);
      
}
      
}
