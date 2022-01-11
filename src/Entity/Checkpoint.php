<?php

namespace App\Entity;

use App\Repository\CheckpointRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CheckpointRepository::class)
 */
class Checkpoint
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\ManyToMany(targetEntity=Producteur::class, inversedBy="checkpoints")
     */
    private $producteurs;

    public function __construct()
    {
        $this->producteurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection|Producteur[]
     */
    public function getProducteurs(): Collection
    {
        return $this->producteurs;
    }

    public function addProducteur(Producteur $producteur): self
    {
        if (!$this->producteurs->contains($producteur)) {
            $this->producteurs[] = $producteur;
        }

        return $this;
    }

    public function removeProducteur(Producteur $producteur): self
    {
        $this->producteurs->removeElement($producteur);

        return $this;
    }
}
