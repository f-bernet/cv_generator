<?php

namespace App\Entity;

use App\Repository\CVRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CVRepository::class)]
class CV
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToMany(targetEntity: Diplome::class)]
    private $cv_diplomes;

    #[ORM\ManyToMany(targetEntity: Experience::class)]
    private $cv_experiences;

    #[ORM\ManyToMany(targetEntity: Network::class)]
    private $cv_networks;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'user_cvs')]
    #[ORM\JoinColumn(nullable: false)]
    private $cv_user;

    #[ORM\ManyToMany(targetEntity: Competence::class)]
    private $cv_competences;

    public function __construct()
    {
        $this->cv_diplomes = new ArrayCollection();
        $this->cv_experiences = new ArrayCollection();
        $this->cv_networks = new ArrayCollection();
        $this->cv_competences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Diplome[]
     */
    public function getCvDiplomes(): Collection
    {
        return $this->cv_diplomes;
    }

    public function addCvDiplome(Diplome $cvDiplome): self
    {
        if (!$this->cv_diplomes->contains($cvDiplome)) {
            $this->cv_diplomes[] = $cvDiplome;
        }

        return $this;
    }

    public function removeCvDiplome(Diplome $cvDiplome): self
    {
        $this->cv_diplomes->removeElement($cvDiplome);

        return $this;
    }

    /**
     * @return Collection|Experience[]
     */
    public function getCvExperiences(): Collection
    {
        return $this->cv_experiences;
    }

    public function addCvExperience(Experience $cvExperience): self
    {
        if (!$this->cv_experiences->contains($cvExperience)) {
            $this->cv_experiences[] = $cvExperience;
        }

        return $this;
    }

    public function removeCvExperience(Experience $cvExperience): self
    {
        $this->cv_experiences->removeElement($cvExperience);

        return $this;
    }

    /**
     * @return Collection|Network[]
     */
    public function getCvNetworks(): Collection
    {
        return $this->cv_networks;
    }

    public function addCvNetwork(Network $cvNetwork): self
    {
        if (!$this->cv_networks->contains($cvNetwork)) {
            $this->cv_networks[] = $cvNetwork;
        }

        return $this;
    }

    public function removeCvNetwork(Network $cvNetwork): self
    {
        $this->cv_networks->removeElement($cvNetwork);

        return $this;
    }

    public function getCvUser(): ?User
    {
        return $this->cv_user;
    }

    public function setCvUser(?User $cv_user): self
    {
        $this->cv_user = $cv_user;

        return $this;
    }

    /**
     * @return Collection|Competence[]
     */
    public function getCvCompetences(): Collection
    {
        return $this->cv_competences;
    }

    public function addCvCompetence(Competence $cvCompetence): self
    {
        if (!$this->cv_competences->contains($cvCompetence)) {
            $this->cv_competences[] = $cvCompetence;
        }

        return $this;
    }

    public function removeCvCompetence(Competence $cvCompetence): self
    {
        $this->cv_competences->removeElement($cvCompetence);

        return $this;
    }
}
