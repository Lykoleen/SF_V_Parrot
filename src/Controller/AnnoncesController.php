<?php

namespace App\Controller;

use App\Repository\VehicleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnoncesController extends AbstractController
{
    #[Route('/annonces', name: 'annonces')]
    public function index(VehicleRepository $vehicleRepository): Response
    {
        $annonces = $vehicleRepository->findAll();
       

        return $this->render('annonces/index.html.twig', compact(
            'annonces',
        ));
    }

    #[Route('/annonces/{id}', name: 'annonces_show')]
    public function show($id, VehicleRepository $vehicleRepository): Response
    {  

        $annonce = $vehicleRepository->find($id);

         // Vérifier si l'annonce existe
         if (!$annonce) {
            throw $this->createNotFoundException('L\'annonce n\'existe pas');
            
            return $this->redirectToRoute('annonces');
        }

        return $this->render('annonces/show.html.twig', compact(
            'annonce',
        ));
    }
}
