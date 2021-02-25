<?php

namespace App\Entity;

use App\Repository\SeanceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SeanceRepository::class)
 */
class Seance
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Activity::class, inversedBy="seances")
     * @ORM\JoinColumn(nullable=false)
     */
    private $CodaAct;

    /**
     * @ORM\ManyToOne(targetEntity=Coach::class, inversedBy="seances")
     */
    private $CodeCo;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     */
    private $DateSe;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     */
    private $heureDebut;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     */
    private $heureFin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodaAct(): ?Activity
    {
        return $this->CodaAct;
    }

    public function setCodaAct(?Activity $CodaAct): self
    {
        $this->CodaAct = $CodaAct;

        return $this;
    }

    public function getCodeCo(): ?Coach
    {
        return $this->CodeCo;
    }

    public function setCodeCo(?Coach $CodeCo): self
    {
        $this->CodeCo = $CodeCo;

        return $this;
    }

    public function getDateSe(): ?\DateTimeInterface
    {
        return $this->DateSe;
    }

    public function setDateSe(\DateTimeInterface $DateSe): self
    {
        $this->DateSe = $DateSe;

        return $this;
    }

    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->heureDebut;
    }

    public function setHeureDebut(\DateTimeInterface $heureDebut): self
    {
        $this->heureDebut = $heureDebut;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->heureFin;
    }

    public function setHeureFin(\DateTimeInterface $heureFin): self
    {
        $this->heureFin = $heureFin;

        return $this;
    }
}
