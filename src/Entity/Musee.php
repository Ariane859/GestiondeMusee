<?php

namespace App\Entity;

use App\Repository\MuseeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=MuseeRepository::class)
 * @UniqueEntity("numMus")
 */
class Musee
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
    private $numMus;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomMus;

    /**
     * @ORM\Column(type="integer")
     */
    private $nblivres;

    /**
     * @ORM\ManyToOne(targetEntity=Pays::class, inversedBy="musees")
     * @ORM\JoinColumn(nullable=false)
     */
    private $codePays;

    /**
     * @ORM\OneToMany(targetEntity=Bibliotheque::class, mappedBy="numMus")
     */
    private $bibliotheques;

    /**
     * @ORM\OneToMany(targetEntity=Visiter::class, mappedBy="numMus")
     */
    private $visiters;

    public function __construct()
    {
        $this->bibliotheques = new ArrayCollection();
        $this->visiters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumMus(): ?int
    {
        return $this->numMus;
    }

    public function setNumMus(int $numMus): self
    {
        $this->numMus = $numMus;

        return $this;
    }

    public function getNomMus(): ?string
    {
        return $this->nomMus;
    }

    public function setNomMus(string $nomMus): self
    {
        $this->nomMus = $nomMus;

        return $this;
    }

    public function getNblivres(): ?int
    {
        return $this->nblivres;
    }

    public function setNblivres(int $nblivres): self
    {
        $this->nblivres = $nblivres;

        return $this;
    }

    public function getCodePays(): ?pays
    {
        return $this->codePays;
    }

    public function setCodePays(?pays $codePays): self
    {
        $this->codePays = $codePays;

        return $this;
    }

    public function __toString()
    {
        return $this->nomMus;
    }

    /**
     * @return Collection|Bibliotheque[]
     */
    public function getBibliotheques(): Collection
    {
        return $this->bibliotheques;
    }

    public function addBibliotheque(Bibliotheque $bibliotheque): self
    {
        if (!$this->bibliotheques->contains($bibliotheque)) {
            $this->bibliotheques[] = $bibliotheque;
            $bibliotheque->setNumMus($this);
        }

        return $this;
    }

    public function removeBibliotheque(Bibliotheque $bibliotheque): self
    {
        if ($this->bibliotheques->contains($bibliotheque)) {
            $this->bibliotheques->removeElement($bibliotheque);
            // set the owning side to null (unless already changed)
            if ($bibliotheque->getNumMus() === $this) {
                $bibliotheque->setNumMus(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Visiter[]
     */
    public function getVisiters(): Collection
    {
        return $this->visiters;
    }

    public function addVisiter(Visiter $visiter): self
    {
        if (!$this->visiters->contains($visiter)) {
            $this->visiters[] = $visiter;
            $visiter->setNumMus($this);
        }

        return $this;
    }

    public function removeVisiter(Visiter $visiter): self
    {
        if ($this->visiters->contains($visiter)) {
            $this->visiters->removeElement($visiter);
            // set the owning side to null (unless already changed)
            if ($visiter->getNumMus() === $this) {
                $visiter->setNumMus(null);
            }
        }

        return $this;
    }

    

}
