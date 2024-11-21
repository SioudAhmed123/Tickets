<?php

namespace App\Controller;

use App\Repository\ReservationRepository;
use App\Repository\TicketsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\EntityManagerInterface;

class CheckoutController extends AbstractController
{
    private $entityManager;
    #[Route('/checkout', name: 'app_checkout')]
    public function index(ReservationRepository $reservationRepository): Response
    {
        
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('You must be logged in to view the checkout page.');
        }

       
        $reservations = $reservationRepository->findBy(['User_id' => $user]);

       
        $totalCost = array_reduce(
            $reservations,
            function ($sum, $reservation) {
                return $sum + $reservation->getTicket()->getPrice() * $reservation->getQuantity();
            },
            0
        );

        return $this->render('checkout/index.html.twig', [
            'reservations' => $reservations,
            'totalCost' => $totalCost,
        ]);
    }
   

    #[Route('/checkout/confirm', name: 'app_checkout_confirm', methods: ['POST'])]
    public function confirmCheckout(ReservationRepository $reservationRepository, TicketsRepository $ticketsRepository): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('You must be logged in to confirm your reservation.');
        }

        $reservations = $reservationRepository->findBy(['User_id' => $user]);

        foreach ($reservations as $reservation) {
            $ticket = $reservation->getTicket();
            $ticket->setQuantity($ticket->getQuantity() - $reservation->getQuantity());
            $ticketsRepository->save($ticket); 
        }

  
        foreach ($reservations as $reservation) {
            $reservationRepository->remove($reservation); 
        }

        return $this->redirectToRoute('app_home'); 
    }
    
}
