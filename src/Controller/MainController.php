<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Entity\Testimonial;
use App\Form\Type\TestimonialType;
use App\Repository\PictureRepository;
use App\Repository\ProductRepository;
use App\Repository\ServiceRepository;
use App\Repository\TestimonialRepository;
use App\Repository\VehicleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

class MainController extends AbstractController
{
    private $manager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->manager = $entityManager;
    }

    #[Route('/', name: 'accueil')]
    public function index(PictureRepository $pictureRepository, ProductRepository $productRepository, ServiceRepository $serviceRepository, VehicleRepository $vehicleRepository, TestimonialRepository $testimonialRepository, Request $request): Response
    {
        // Récupération des données nécessaires à la vue Main.
        // Gestion des services

        $services = $serviceRepository->findAll();

        // Récupération des images
        $imagesServices = [];
        foreach ($services as $service) {
            $serviceImage = $pictureRepository->findOneByServiceId($service->getId());
            $image = $serviceImage->getName();
            $imagesServices[] = $image;
        }

        //Gestion des annonces de voitures
        $vehicles = $vehicleRepository->findBy3();
        $pictureInstance = new Picture;
        
        $imagesVehicles = [];
        $nameBrands = [];
        $nameModels = [];
        $prices = [];
        foreach ($vehicles as $vehicle) {
            $annonceImages = $pictureRepository->findOneByProductId($vehicle->getId());
            $nameBrands[] = $vehicle->getBrands()->getName();
            $nameModels[] = $vehicle->getModels()->getName();
            $prices[] = $vehicle->getPrice();
            foreach ($annonceImages as $image) {
                $imagesVehicles[] = $image->getName();
            }
        }

        // Gestion des testimonials
        $testimonials = $testimonialRepository->findByValidated(1);

        $testimonialsInstance = new Testimonial();

        $form = $this->createForm(TestimonialType::class, $testimonialsInstance);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $testimonialsInstance = $form->getData();

            $this->manager->persist($testimonialsInstance);
            $this->manager->flush();

        }
        return $this->render('main/index.html.twig', compact(
            "services",
            "imagesServices",
            "imagesVehicles",
            "nameBrands",
            "nameModels",
            "prices",
            "vehicles",
            "testimonials",
            "form"
        ));
    }
}
