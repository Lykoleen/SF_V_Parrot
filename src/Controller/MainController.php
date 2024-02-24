<?php

namespace App\Controller;

use App\Entity\Service;
use App\Entity\Testimonial;
use App\Form\Type\TestimonialType;
use App\Repository\PictureRepository;
use App\Repository\ServiceRepository;
use App\Repository\TestimonialRepository;
use App\Repository\VehicleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
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
    public function index(PictureRepository $pictureRepository, ServiceRepository $serviceRepository, VehicleRepository $vehicleRepository, TestimonialRepository $testimonialRepository, Request $request): Response
    {
        // Récupération des données nécessaires à la vue Main.
    
        $services = $serviceRepository->findAll();
        
        // Récupération des images
        $imagesServices = [];
        foreach ($services as $service) {
            $serviceImage = $pictureRepository->findOneByServiceId($service->getId());
            $image = $serviceImage->getName();
            $imagesServices[] = $image;
        }
        

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
                "imagesServices",
                "annonces",
                "testimonials",
                "form"
            ));
        }
        
        
}
