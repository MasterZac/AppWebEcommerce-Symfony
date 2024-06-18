<?php

namespace App\Controller\Admin;

use App\Entity\Categorias;
use App\Entity\Productos;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    private AdminUrlGenerator $adminUrlGenerator;

    public function __construct( AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;   
    }
    
    #[Route('/admin', name: 'dashboard_admin')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $url = $this->adminUrlGenerator
            ->setController(ProductosCrudController::class)
            ->generateUrl();
        return $this->redirect($url);
    }
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Smart Fingers');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('E-commerce');

        yield MenuItem::section('');

        yield MenuItem::subMenu('Productos', 'fas fa-box')->setSubItems([
            MenuItem::linkToCrud('Agregar productos', 'fas fa-plus', Productos::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Mostrar Productos', 'fas fa-plus', Productos::class)
        ]);

        yield MenuItem::section('');

        yield MenuItem::subMenu('Categorias', 'fas fa-tags')->setSubItems([
            MenuItem::linkToCrud('Add Categorias', 'fas fa-plus', Categorias::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Categorias', 'fas fa-plus', Categorias::class)
        ]);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
