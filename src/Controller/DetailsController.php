<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Events;
use App\Repository\EventsRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TicketsRepository; 

class DetailsController extends AbstractController
{
    
     
  #[Route("/ticket/{id}", name:"app_ticket_details")]
 
public function showTicketDetails($id, TicketsRepository $ticketRepository, EventsRepository $eventRepository): Response
{
    $ticket = $ticketRepository->find($id);

    if (!$ticket) {
        throw $this->createNotFoundException('The ticket does not exist');
    }

    // Retrieve the related event using event_id
    $event = $eventRepository->find($ticket->getEventId());

    if (!$event) {
        throw $this->createNotFoundException('The associated event does not exist');
    }

    // Fetch similar tickets based on the event's category ID
    $similarTickets = $ticketRepository->findSimilarTicketsByCategory($event->getCategory()->getId(), $ticket->getId());

    return $this->render('details/index.html.twig', [
        'ticket' => $ticket,
        'event' => $event,
        'similarTickets' => $similarTickets,
    ]);
}

}
