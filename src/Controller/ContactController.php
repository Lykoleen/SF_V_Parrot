<?php

namespace App\Controller;

use App\Form\Type\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {

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

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
