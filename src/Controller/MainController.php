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

        $services = $serviceRepository->findAll();
        $vehicles = $vehicleRepository->findBy3();


        // Gestion des testimonials
        $testimonials = $testimonialRepository->findByValidated(1);

        $testimonialsInstance = new Testimonial();

        $form = $this->createForm(TestimonialType::class, $testimonialsInstance);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $testimonialsInstance = $form->getData();

            $this->manager->persist($testimonialsInstance);
            $this->manager->flush();
            $this->addFlash('success', 'Votre message a été envoyé avec succès !');

        } else {
            $this->addFlash('error', 'Désolé, votre message n\' pas pu être envoyé.');
        }
        return $this->render('main/index.html.twig', compact(
            "services",
            "vehicles",
            "testimonials",
            "form"
        ));
    }
}
