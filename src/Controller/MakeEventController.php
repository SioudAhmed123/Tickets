<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MakeEventController extends AbstractController
{
    #[Route('/make/event', name: 'app_make_event')]
    public function index(): Response
    {
        return $this->render('make_event/index.html.twig', [
            'controller_name' => 'MakeEventController',
        ]);
    }
}
