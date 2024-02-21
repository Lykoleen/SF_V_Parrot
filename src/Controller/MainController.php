<?php

namespace App\Controller;

use App\Entity\Testimonial;
use App\Form\Type\TestimonialType;
use App\Repository\ServiceRepository;
use App\Repository\TestimonialRepository;
use App\Repository\VehicleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    private $manager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->manager = $entityManager;
    }

    #[Route('/', name: 'accueil')]
    public function index(ServiceRepository $serviceRepository, VehicleRepository $vehicleRepository, TestimonialRepository $testimonialRepository, Request $request): Response
    {
        // Récupération des données nécessaires à la vue Main.

        $services = $serviceRepository->findAll();
        $annonces = $vehicleRepository->findBy3();
        $testimonials = $testimonialRepository->findByValidated(1);   

        // Gestion du formulaire des testimonials

        // $surname = $request->request->get('surname');
        // $name = $request->request->get('name');
        // $message = $request->request->get('message');
        // $score = $request->request->get('score');

        $testimonialsInstance = new Testimonial();
        // $testimonialsInstance->setName($name)
        //     ->setSurname($surname)
        //     ->setMessage($message)
        //     ->setScore($score);
        
        $form = $this->createForm(TestimonialType::class, $testimonialsInstance);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $testimonialsInstance = $form->getData();
            
            $this->manager->persist($testimonialsInstance);
            $this->manager->flush();

            return $this->redirectToRoute('accueil');
        }

            return $this->render('main/index.html.twig', compact(
                "services",
                "annonces",
                "testimonials",
                "form"
            ));
        }
        
        
}
