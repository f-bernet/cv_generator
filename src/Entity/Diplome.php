<?php

namespace App\Entity;

use App\Repository\DiplomeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DiplomeRepository::class)]
class Diplome
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $year;

    #[ORM\Column(type: 'string', length: 50)]
    private $title;

    #[ORM\Column(type: 'string', length: 50)]
    private $localisation;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'diplomes')]
    #[ORM\JoinColumn(nullable: false)]
    private $diplome_user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getDiplomeUser(): ?User
    {
        return $this->diplome_user;
    }

    public function setDiplomeUser(?User $diplome_user): self
    {
        $this->diplome_user = $diplome_user;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getYear().' : '.$this->getTitle().' '.$this->getLocalisation();
    }
}
