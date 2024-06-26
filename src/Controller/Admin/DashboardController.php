<?php

namespace App\Controller\Admin;

use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Energy;
use App\Entity\Garage;
use App\Entity\Gearbox;
use App\Entity\Model;
use App\Entity\Product;
use App\Entity\Schedule;
use App\Entity\Service;
use App\Entity\Testimonial;
use App\Entity\Type;
use App\Entity\User;
use App\Entity\Vehicle;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;


class DashboardController extends AbstractDashboardController
{
    private $authorizationChecker;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(ProductCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Administration')
            ->setFaviconPath('/build/images/logo_blanc.svg')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Ajout produits/véhicules');
        yield MenuItem::linkToCrud('Produits', 'fa-solid fa-boxes-stacked', Product::class);
        yield MenuItem::linkToCrud('Véhicules', 'fa-solid fa-car', Vehicle::class);

        yield MenuItem::section('Paramètres Véhicules');
        yield MenuItem::linkToCrud('Marque', 'fa-solid fa-m', Brand::class);
        yield MenuItem::linkToCrud('Carburant', 'fa-solid fa-bolt', Energy::class);
        yield MenuItem::linkToCrud('Boite de vitesse', 'fa-solid fa-gear', Gearbox::class);
        yield MenuItem::linkToCrud('Modèle', 'fa-solid fa-m', Model::class);

        yield MenuItem::section('Paramètres Produits');
        yield MenuItem::linkToCrud('Catégorie', 'fa-solid fa-c', Category::class);
        yield MenuItem::linkToCrud('Type', 'fa-solid fa-t', Type::class);

        yield MenuItem::section('Avis Clients');
        yield MenuItem::linkToCrud('Avis Clients', 'fa-solid fa-star', Testimonial::class);

        if ($this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            yield MenuItem::section('Section Admin');
            yield MenuItem::linkToCrud('Service', 'fa-regular fa-handshake', Service::class);
            yield MenuItem::linkToCrud('Horaires d\'ouverture', 'fa-solid fa-clock', Schedule::class);
            yield MenuItem::linkToCrud('Employés', 'fa-solid fa-users', User::class);
            yield MenuItem::linkToCrud('Garage', 'fa-solid fa-warehouse', Garage::class);
        }
    }
}
