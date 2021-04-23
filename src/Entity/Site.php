<?php

namespace App\Entity;

use App\Repository\SiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=SiteRepository::class)
 * @UniqueEntity("nomSite")
 */
class Site
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomSite;

    /**
     * @ORM\Column(type="date")
     * @var dateTime
     */
    private $anneedecouv;

    /**
     * @ORM\ManyToOne(targetEntity=Pays::class, inversedBy="sites")
     * @ORM\JoinColumn(nullable=false)
     */
    private $codePays;

    /**
     * @ORM\OneToMany(targetEntity=Referencer::class, mappedBy="nomSite")
     */
    private $referencers;

    public function __construct()
    {
        $this->referencers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSite(): ?string
    {
        return $this->nomSite;
    }

    public function setNomSite(string $nomSite): self
    {
        $this->nomSite = $nomSite;

        return $this;
    }

    public function getAnneedecouv(): ?\DateTimeInterface
    {
        return $this->anneedecouv;
    }

    public function setAnneedecouv(\DateTimeInterface $anneedecouv): self
    {
        $this->anneedecouv = $anneedecouv;

        return $this;
    }

    public function getCodePays(): ?Pays
    {
        return $this->codePays;
    }

    public function setCodePays(?Pays $codePays): self
    {
        $this->codePays = $codePays;

        return $this;
    }

    public function __toString()
    {
        return $this->nomSite;
    }

    /**
     * @return Collection|Referencer[]
     */
    public function getReferencers(): Collection
    {
        return $this->referencers;
    }

    public function addReferencer(Referencer $referencer): self
    {
        if (!$this->referencers->contains($referencer)) {
            $this->referencers[] = $referencer;
            $referencer->setNomSite($this);
        }

        return $this;
    }

    public function removeReferencer(Referencer $referencer): self
    {
        if ($this->referencers->contains($referencer)) {
            $this->referencers->removeElement($referencer);
            // set the owning side to null (unless already changed)
            if ($referencer->getNomSite() === $this) {
                $referencer->setNomSite(null);
            }
        }

        return $this;
    }

    
}
