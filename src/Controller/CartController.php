<?php

namespace App\Controller;

use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class CartController extends AbstractController
{
    
    #[Route('/cart', name: 'app_cart')]
    public function index(ReservationRepository $reservationRepository, ): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('You must be logged in to view your cart.');
        }

        $reservations = $reservationRepository->findBy(['User_id' => $user]);

        $totalCost = array_reduce(
            $reservations,
            function ($sum, $reservation) {
                return $sum + $reservation->getTicket()->getPrice() * $reservation->getQuantity();
            },
            0
        );

        return $this->render('cart/index.html.twig', [
            'reservations' => $reservations,
            'totalCost' => $totalCost,
        ]);
    }
    #[Route('/cart/remove/{id}', name: 'remove_from_cart')]
    public function removeFromCart(int $id, ReservationRepository $reservationRepository,EntityManagerInterface $entityManager ): RedirectResponse
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('You must be logged in to remove items from your cart.');
        }

        $reservation = $reservationRepository->find($id);

        if (!$reservation) {
            throw $this->createNotFoundException('Reservation not found.');
        }
        $entityManager->remove($reservation);
        $entityManager->flush();
    

        // Redirect back to the cart page
        $this->addFlash('success', 'The reservation has been removed from your cart.');

        return $this->redirectToRoute('app_cart');
    }
   
}
