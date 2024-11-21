<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

   

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Tickets $Ticket = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Users $User = null;

    #[ORM\Column(nullable: true)]
    private ?int $Quantity = null;

    #[ORM\ManyToOne]
    private ?User $User_id = null;

  
    public function getId(): ?int
    {
        return $this->id;
    }

   

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getTicket(): ?Tickets
    {
        return $this->Ticket;
    }

    public function setTicket(?Tickets $Ticket): static
    {
        $this->Ticket = $Ticket;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->User;
    }

    public function setUser(?Users $User): static
    {
        $this->User = $User;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->Quantity;
    }

    public function setQuantity(?int $Quantity): static
    {
        $this->Quantity = $Quantity;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->User_id;
    }

    public function setUserId(?User $User_id): static
    {
        $this->User_id = $User_id;

        return $this;
    }
}
