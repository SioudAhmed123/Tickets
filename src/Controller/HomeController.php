<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EventsRepository;
use Symfony\Component\HttpFoundation\Request;
class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(Request $request,EventsRepository $eventRepository): Response
    {
        
        $user = $this->getUser();
        $name = $request->query->get('name');
        $location = $request->query->get('location');
        $date = $request->query->get('date');

        if ($name || $location || $date) {
            $events = $eventRepository->findByCriteria($name, $location, $date);
        } else {
            $events = $eventRepository->findAll(); 
        }

        $events = $eventRepository->findByCriteria($name, $location, $date);

        return $this->render('home/index.html.twig', [
            'user' => $user,
            'events' => $events,
        ]);
    }
   
}
