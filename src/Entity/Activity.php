<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActivityRepository::class)
 */
class Activity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     */
    private $CodeAct;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $LibAct;

    /**
     * @ORM\OneToMany(targetEntity=Seance::class, mappedBy="CodaAct")
     */
    private $seances;

    public function __construct()
    {
        $this->seances = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeAct(): ?int
    {
        return $this->CodeAct;
    }

    public function setCodeAct(int $CodeAct): self
    {
        $this->CodeAct = $CodeAct;

        return $this;
    }

    public function getLibAct(): ?string
    {
        return $this->LibAct;
    }

    public function setLibAct(string $LibAct): self
    {
        $this->LibAct = $LibAct;

        return $this;
    }

    /**
     * @return Collection|Seance[]
     */
    public function getSeances(): Collection
    {
        return $this->seances;
    }

    public function addSeance(Seance $seance): self
    {
        if (!$this->seances->contains($seance)) {
            $this->seances[] = $seance;
            $seance->setCodaAct($this);
        }

        return $this;
    }

    public function removeSeance(Seance $seance): self
    {
        if ($this->seances->contains($seance)) {
            $this->seances->removeElement($seance);
            // set the owning side to null (unless already changed)
            if ($seance->getCodaAct() === $this) {
                $seance->setCodaAct(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->LibAct;
    }
}
