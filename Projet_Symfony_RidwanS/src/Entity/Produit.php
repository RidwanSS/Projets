<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")
 */
class Produit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180)
     * @Assert\NotNull
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotNull
     */
    private $prix;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $stock;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contenu", mappedBy="produit")
     */
    private $contenus;

    public function __construct()
    {
        $this->contenus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Contenu[]
     */
    public function getContenus(): Collection
    {
        return $this->contenus;
    }

    public function addContenus(Contenu $contenus): self
    {
        if (!$this->contenus->contains($contenus)) {
            $this->contenus[] = $contenus;
            $contenus->setProduit($this);
        }

        return $this;
    }

    public function removeContenus(Contenu $contenus): self
    {
        if ($this->contenus->contains($contenus)) {
            $this->contenus->removeElement($contenus);
            // set the owning side to null (unless already changed)
            if ($contenus->getProduit() === $this) {
                $contenus->setProduit(null);
            }
        }

        return $this;
    }

    public function __toString(){
        return $this->nom;
    }

    /**
    * @ORM\PreRemove
    */
    public function delete(){
        $chemin = __DIR__.'/../../public/uploads/'.$this->getImage();
        unlink($chemin);
    } 

}
