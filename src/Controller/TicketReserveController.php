<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Repository\TicketsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;

class TicketReserveController extends AbstractController
{
    #[Route('/tickets/{id}/reserve', name: 'app_ticket_reserve')]
    public function reserve(
        int $id,
        Request $request,
        TicketsRepository $ticketRepository,
        EntityManagerInterface $em
    ): Response {
        $ticket = $ticketRepository->find($id);
        if (!$ticket) {
            throw $this->createNotFoundException('Ticket not found');
        }

        $availableQuantity = $ticket->getQuantity();
        $maxQuantity = (int) floor($availableQuantity / 4); // Max allowable quantity is half of available tickets.

        $form = $this->createFormBuilder()
            ->add('quantity', IntegerType::class, [
                'constraints' => [
                    new Positive(),
                    new LessThanOrEqual(['value' => $maxQuantity]),
                ],
                'label' => 'How many tickets would you like to buy?',
            ])
            ->add('confirm', SubmitType::class, ['label' => 'Add to Cart'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $quantity = $data['quantity'];
            $user = $this->getUser();

            if (!$user) {
                throw $this->createAccessDeniedException('You need to log in to make a reservation.');
            }

            $reservation = new Reservation();
            $reservation->setUserId($user);
            $reservation->setTicket($ticket);
            $reservation->setQuantity($quantity);
            $reservation->setCreatedAt(new \DateTimeImmutable());

            $em->persist($reservation);

            $ticket->setQuantity($availableQuantity - $quantity);
            $em->persist($ticket);

            $em->flush();

            return $this->redirectToRoute('app_cart');
        }

        return $this->render('ticket_reserve/index.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView(),
        ]);
    }
}
