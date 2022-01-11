<?php

namespace App\Entity;

use App\Repository\ProducteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use LogicException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=ProducteurRepository::class)
 */
class Producteur extends FinalUser
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
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="producteur")
     */
    private $products;

    /**
     * @ORM\ManyToMany(targetEntity=Checkpoint::class, mappedBy="producteurs")
     */
    private $checkpoints;



    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->checkpoints = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setProducteur($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getProducteur() === $this) {
                $product->setProducteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Checkpoint[]
     */
    public function getCheckpoints(): Collection
    {
        return $this->checkpoints;
    }

    public function addCheckpoint(Checkpoint $checkpoint): self
    {
        if (!$this->checkpoints->contains($checkpoint)) {
            $this->checkpoints[] = $checkpoint;
            $checkpoint->addProducteur($this);
        }

        return $this;
    }

    public function removeCheckpoint(Checkpoint $checkpoint): self
    {
        if ($this->checkpoints->removeElement($checkpoint)) {
            $checkpoint->removeProducteur($this);
        }

        return $this;
    }


    public function acceptCheckPoint(Checkpoint $checkpoint)
    {
        if (!$this->checkpoints->contains($checkpoint)) {
            throw new LogicException(" not related");
        }
        // $checkpoint->setAccepted(true);
        // foreach ($this->checkpoints as $s) {
        //     if ($s !== $checkpoint) {
        //         $s->setAccepted(false);
        //     }
        // }
    }
}
