<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function index(): Response
    {
        $websiteName = "Garage V.Parrot";

        return $this->render('main/index.html.twig', compact(
            "websiteName"
        ));
    }
}
