<?php

namespace App\Controller;

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
        $annonces = $vehicleRepository->findByFilters($filtersBrands, $filtersModels, $filtersEnergies);
        
       
        // Pour les filtres 
        $brands = $brandRepository->findAll();
        $models = $modelRepository->findAll();
        $energies = $energyRepository->findAll();
       
        if ($request->get('ajax')) {
            return new JsonResponse([
                'content' => $this->renderView('annonces/_annonces.html.twig', ['annonces' => $annonces])
            ]);
        }

        return $this->render('annonces/index.html.twig', compact(
            'annonces',
            'brands',
            'models',
            'energies',
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
