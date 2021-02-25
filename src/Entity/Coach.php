<?php

namespace App\Entity;

use App\Repository\CoachRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CoachRepository::class)
 */
class Coach
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $CodeCo;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 3,
     *      max = 15,
     *      minMessage = "Coach first name must be at least {{ limit }} characters long",
     *      maxMessage = "Coach first name cannot be longer than {{ limit }} characters"
     * )
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 3,
     *      max = 15,
     *      minMessage = "Coach last name must be at least {{ limit }} characters long",
     *      maxMessage = "Coach last name cannot be longer than {{ limit }} characters"
     * )
     */
    private $last_name;

    /**
     * @ORM\OneToMany(targetEntity=Seance::class, mappedBy="CodeCo")
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

    public function getCodeCo(): ?int
    {
        return $this->CodeCo;
    }

    public function setCodeCo(int $CodeCo): self
    {
        $this->CodeCo = $CodeCo;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

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
            $seance->setCodeCo($this);
        }

        return $this;
    }

    public function removeSeance(Seance $seance): self
    {
        if ($this->seances->contains($seance)) {
            $this->seances->removeElement($seance);
            // set the owning side to null (unless already changed)
            if ($seance->getCodeCo() === $this) {
                $seance->setCodeCo(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->first_name;
    }
}
