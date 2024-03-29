<?php

namespace App\Controller;

use App\Entity\Vehicle;
use App\Form\Type\ContactType;
use App\Repository\BrandRepository;
use App\Repository\EnergyRepository;
use App\Repository\ModelRepository;
use App\Repository\VehicleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class AnnoncesController extends AbstractController
{
    #[Route('/annonces', name: 'annonces')]
    public function index(VehicleRepository $vehicleRepository, BrandRepository $brandRepository, ModelRepository $modelRepository, EnergyRepository $energyRepository, Request $request): Response
    {
        $filtersBrands = $request->get('brands');
        $filtersModels = $request->get('models');
        $filtersEnergies = $request->get('energies');
        $filtersMinPrice = $request->get('min') !== null ? $request->get('min') : 0;
        $filtersMaxPrice = $request->get('max') !== null ? $request->get('max') : 500000;        
        $annonces = $vehicleRepository->findByFilters($filtersBrands, $filtersModels, $filtersEnergies, $filtersMinPrice, $filtersMaxPrice);

        $minPrice = PHP_INT_MAX; // Initialisation du prix minimum à une valeur très grande
        $maxPrice = 0; // Initialisation du prix maximum à zéro
        
        foreach ($annonces as $annonce) {
            // Obtenez le prix de chaque annonce
            
            $prix = $annonce->getPrice();
        
            // Mettez à jour le prix minimum si le prix actuel est inférieur au prix minimum actuel
            if ($prix < $minPrice) {
                $minPrice = $prix;
            }
        
            // Mettez à jour le prix maximum si le prix actuel est supérieur au prix maximum actuel
            if ($prix > $maxPrice) {
                $maxPrice = $prix;
            }
        }
        
        
        // Maintenant, $minPrice contient le prix minimum et $maxPrice contient le prix maximum de toutes les annonces
        
        // Pour les filtres 
        $brands = $brandRepository->findAll();
        $models = $modelRepository->findAll();
        $energies = $energyRepository->findAll();
       
        if ($request->get('ajax')) {

            return new JsonResponse([
                'content' => $this->renderView('annonces/_annonces.html.twig', compact(
                    'annonces',
                ))
            ]);
        }

        return $this->render('annonces/index.html.twig', compact(
            'annonces',
            'brands',
            'models',
            'energies',
            'minPrice',
            'maxPrice',
        ));
    }

    #[Route('/annonces/{id}', name: 'annonces_show')]
    public function show($id, VehicleRepository $vehicleRepository, Request $request, MailerInterface $mailer): Response
    {  

        $annonce = $vehicleRepository->find($id);

         // Vérifier si l'annonce existe
         if (!$annonce) {
            throw $this->createNotFoundException('L\'annonce n\'existe pas');
            
            return $this->redirectToRoute('annonces');
        }

        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $formData = $form->getData();
            $email = (new Email())
            ->from($formData['email'])
            ->to('tony.rabillard16@gmail.com')
            ->subject($formData['subject'])
            ->text('De : ' . $formData['name'] . ' ' . $formData['surname'] . ' (' . $formData['email'] . ')' . "\n\n" . $formData['message']);

            try {
                $mailer->send($email);
                $this->addFlash('success', 'Votre message a été envoyé avec succès !');
            } catch (TransportExceptionInterface $e) {
                $e = "L'envoi du mail n'a pas fonctionné.";
                return $e;
            }
        }

        return $this->render('annonces/show.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
        ]);
    }
}
