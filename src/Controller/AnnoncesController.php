<?php

namespace App\Controller;

use App\Form\Type\ContactType;
use App\Repository\BrandRepository;
use App\Repository\EnergyRepository;
use App\Repository\ModelRepository;
use App\Repository\VehicleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $filtersMinPrice = $request->get('minPrice') !== null ? $request->get('minPrice') : 0;
        $filtersMaxPrice = $request->get('maxPrice') !== null ? $request->get('maxPrice') : 500000;
        $filtersMinMileage = $request->get('minMileage') !== null ? $request->get('minMileage') : 0;
        $filtersMaxMileage = $request->get('maxMileage') !== null ? $request->get('maxMileage') : 500000;
        $filtersMinYears = $request->get('minYears') !== null ? $request->get('minYears') : 1900;  
        $filtersMaxYears = $request->get('maxYears') !== null ? $request->get('maxYears') : 2200;
        $annonces = $vehicleRepository->findByFilters($filtersBrands, $filtersModels, $filtersEnergies, $filtersMinPrice, $filtersMaxPrice, $filtersMinYears, $filtersMaxYears, $filtersMinMileage, $filtersMaxMileage);
        
        $minPrice = PHP_INT_MAX; // Initialisation du prix minimum à une valeur très grande
        $maxPrice = 0; // Initialisation du prix maximum à zéro
        $minYears = PHP_INT_MAX;
        $maxYears = 0;
        $minMileage = PHP_INT_MAX;
        $maxMileage = 0;

        foreach ($annonces as $annonce) {
        
            $prix = $annonce->getPrice();
            $years = $annonce->getYears();
            $mileage = $annonce->getMileage();
        
            // Met à jour le prix minimum si le prix actuel est inférieur au prix minimum actuel
            if ($prix < $minPrice) {
                $minPrice = $prix;
            }
        
            // Met à jour le prix maximum si le prix actuel est supérieur au prix maximum actuel
            if ($prix > $maxPrice) {
                $maxPrice = $prix;
            }

            if ($years < $minYears) {
                $minYears = $years;
            }
            if ($years > $maxYears) {
                $maxYears = $years;
            }

            if ($mileage < $minMileage) {
                $minMileage = $mileage;
            }
            if ($mileage > $maxMileage) {
                $maxMileage = $mileage;
            }

        }
        
        // Pour les filtres 
        $brands = $brandRepository->findAll();
        $models = $modelRepository->findAll();
        $energies = $energyRepository->findAll();
       
        if ($request->get('ajax')) {

            return new JsonResponse([
                'content' => $this->renderView('annonces/_annonces.html.twig', compact(
                    'annonces',
                )),
                'modelsFilters' => $this->renderView('annonces/_modelsFilter.html.twig', compact(
                    'annonces'
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
            'minYears',
            'maxYears',
            'minMileage',
            'maxMileage'
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
            ->from('tony.rabillard@projet.ecfparrotvincent.fr')
            ->to('tony.rabillard@projet.ecfparrotvincent.fr')
            ->subject($formData['subject'])
            ->text('De : ' . $formData['name'] . ' ' . $formData['surname'] . ' (' . $formData['email'] . ')' . "\n\n" . $formData['message']);

            try {
                $mailer->send($email);
                $this->addFlash('success', 'Votre message a été envoyé avec succès !');
            } 
                catch (TransportExceptionInterface $e) {
                $errorMessage = "L'envoi du mail n'a pas fonctionné.";
                $this->addFlash('error', $errorMessage);
                return $this->redirectToRoute('annonces_show', ['id' => $id]);

                // catch (\Exception $e) {
                //     // Capturer toutes les exceptions
                //     dd($e->getMessage()); // Afficher le message de l'exception
            }
        }

        $form = $this->createForm(ContactType::class);

        return $this->render('annonces/show.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
        ]);
    }
}
