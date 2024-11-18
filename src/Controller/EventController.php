<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Event;      // Replace with your actual Event entity path
use App\Entity\Category;   // Replace with your actual Category entity path
use App\Repository\EventsRepository;      // Import Event repository
use App\Repository\CategorieRepository;   // Import Category repository
use App\Repository\TicketsRepository; 
use App\Entity\Events;   // Import Ticket repository

class EventController extends AbstractController
{
    private $eventRepository;
    private $categoryRepository;
    private $ticketRepository;

    public function __construct(EventsRepository $eventRepository, CategorieRepository $categoryRepository, TicketsRepository $ticketRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->categoryRepository = $categoryRepository;
        $this->ticketRepository = $ticketRepository;
    }

    
      #[Route("/event", name:"app_event")]
     
    public function events(Request $request,EntityManagerInterface $em): Response
    {
        $categories = $this->categoryRepository->findAll();
        $events = $this->eventRepository->findAll();
        $categoryId = $request->query->get('category');
        $priceRange = $request->query->get('price');

       
        $filteredEvents = [];

        foreach ($events as $event) {

            $tickets = $this->ticketRepository->findBy(['event_id' => $event->getId()]); 
            
           
            $hasValidTicket = false;

            if ($priceRange) {
                [$minPrice, $maxPrice] = explode('-', str_replace('+', '', $priceRange));

                foreach ($tickets as $ticket) {
                    $ticketPrice = $ticket->getPrice(); 

                    if ($ticketPrice >= (float)$minPrice && ($maxPrice === '' || $ticketPrice <= (float)$maxPrice)) {
                        $hasValidTicket = true;
                        break;
                    }
                }
            } else {
              
                $hasValidTicket = true;
            }

            
            if ($categoryId) {
                if ($event->getCategory()->getId() == $categoryId && $hasValidTicket) {
                    $filteredEvents[] = $event;
                }
            } else {
                if ($hasValidTicket) {
                    $filteredEvents[] = $event;
                }
            }
        }
        
        

        return $this->render('event/index.html.twig', [
            'categories' => $categories,
            'events' => $filteredEvents,
        ]);
    }
}