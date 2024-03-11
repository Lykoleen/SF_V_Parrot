<?php

namespace App\Controller;

use App\Form\Type\ContactType;
use App\Repository\VehicleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function index(VehicleRepository $vehicleRepository): Response
    {
        $annonces = $vehicleRepository->findAll();
       

        return $this->render('annonces/index.html.twig', compact(
            'annonces',
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
