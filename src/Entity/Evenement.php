<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement implements JsonSerializable 
{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le titre ne peut pas être vide.')]
    #[Assert\Length(max: 255, maxMessage: 'Le titre ne peut pas dépasser {{ limit }} caractères.')]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'La description ne peut pas être vide.')]
    #[Assert\Length(max: 255, maxMessage: 'La description ne peut pas dépasser {{ limit }} caractères.')]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: 'La date de début ne peut pas être vide.')]
    #[Assert\Type(type: \DateTimeInterface::class, message: 'La date de début doit être un objet DateTime.')]
    private ?\DateTimeInterface $date_de_debut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: 'La date de fin ne peut pas être vide.')]
    #[Assert\Type(type: \DateTimeInterface::class, message: 'La date de fin doit être un objet DateTime.')]
    private ?\DateTimeInterface $date_de_fin = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le lieu ne peut pas être vide.')]
    #[Assert\Length(max: 255, maxMessage: 'Le lieu ne peut pas dépasser {{ limit }} caractères.')]
    private ?string $lieu = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDateDeDebut(): ?\DateTimeInterface
    {
        return $this->date_de_debut;
    }

    public function setDateDeDebut(\DateTimeInterface $date_de_debut): static
    {
        $this->date_de_debut = $date_de_debut;

        return $this;
    }

    public function getDateDeFin(): ?\DateTimeInterface
    {
        return $this->date_de_fin;
    }

    public function setDateDeFin(\DateTimeInterface $date_de_fin): static
    {
        $this->date_de_fin = $date_de_fin;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): static
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * @return mixed
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'titre' => $this->titre,
            'description' => $this->description,
            'date_de_debut' => $this->date_de_debut,
            'date_de_fin' => $this->date_de_fin,
            'lieu' => $this->lieu,
        ];
    }
}
