<?php

namespace App\Controller\Admin;

use App\Entity\Actor;
use App\Entity\Director;
use App\Entity\Movies;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilmDashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {
        
    }
    #[Route('/', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator->setController(MoviesCrudController::class)->generateUrl();
        return $this->redirect($url);       
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Films');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Películas', 'fa fa-film', Movies::class);
        yield MenuItem::linkToCrud('Actores', 'fa fa-user-secret', Actor::class);
        yield MenuItem::linkToCrud('Directores', 'fa fa-clapperboard', Director::class);
    }
}
