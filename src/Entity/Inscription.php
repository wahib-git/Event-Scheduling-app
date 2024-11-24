<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datel = null;

    #[ORM\Column(length: 50)]
    private ?string $etatl = null;

    #[ORM\ManyToOne(inversedBy: 'Inscription')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Event $events = null;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $Client = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatel(): ?\DateTimeInterface
    {
        return $this->datel;
    }

    public function setDatel(\DateTimeInterface $datel): static
    {
        $this->datel = $datel;

        return $this;
    }

    public function getEtatl(): ?string
    {
        return $this->etatl;
    }

    public function setEtatl(string $etatl): static
    {
        $this->etatl = $etatl;

        return $this;
    }

    public function getEvents(): ?Event
    {
        return $this->events;
    }

    public function setEvents(?Event $events): static
    {
        $this->events = $events;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->Client;
    }

    public function setClient(?Client $Client): static
    {
        $this->Client = $Client;

        return $this;
    }
}
