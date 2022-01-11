<?php

namespace App\DataFixtures;

use App\Entity\Checkpoint;
use App\Entity\Organisateur;
use App\Entity\Product;
use App\Entity\Producteur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        $producteur = new Producteur();
        $producteur->setFirstname("John");
        $producteur->setLastname("Wayne");
        $producteur->setEmail("producteur1@mail.fr");
        $producteur->setPassword($this->hasher->hashPassword($producteur, "password"));
        $producteur->setRoles(['PRODUCTEUR']);
        $producteur->setAddress("2 rue de la paix");
        $producteur->setCity("Paris");
        $manager->persist($producteur);
        $producteur2 = new Producteur();
        $producteur2->setFirstname("John");
        $producteur2->setLastname("Lennon");
        $producteur2->setEmail("producteur2@mail.fr");
        $producteur2->setRoles(['PRODUCTEUR']);
        $producteur2->setPassword($this->hasher->hashPassword($producteur2, "password"));
        $producteur2->setAddress("Avenue matignon");
        $producteur2->setCity("Paris");
        $manager->persist($producteur);
        $manager->persist($producteur2);

        $product = new Product();
        $product->setName("Carottes");
        $product->setQuantity(4);
        $product->setPrice(0.40);
        $product->setWeight(0.25);
        $product->setProducteur($producteur);
        $manager->persist($product);

        $product2 = new Product();
        $product2->setName("Choux");
        $product2->setQuantity(4);
        $product2->setPrice(0.35);
        $product2->setWeight(0.25);
        $product2->setProducteur($producteur2);
        $manager->persist($product2);

        $product3 = new Product();
        $product3->setName("Radis");
        $product3->setQuantity(50);
        $product3->setPrice(0.25);
        $product3->setWeight(0.25);
        $product3->setProducteur($producteur);
        $manager->persist($product3);
        $product4 = new Product();
        $product4->setName("Salades");
        $product4->setQuantity(20);
        $product4->setPrice(0.25);
        $product4->setWeight(0.25);
        $product4->setProducteur($producteur);
        $manager->persist($product4);

        $orga = new Organisateur();
        $orga->setName("Organisateur 01");
        $orga->setEmail("orga1@mail.fr");
        $orga->setPassword($this->hasher->hashPassword($orga, "password"));
        $orga->setRoles(["ADMIN"]);
        $manager->persist($orga);
        $orga2 = new Organisateur();
        $orga2->setName("Organisateur 02");
        $orga2->setEmail("orga2@mail.fr");
        $orga2->setPassword($this->hasher->hashPassword($orga, "password"));
        $orga2->setRoles(["ADMIN"]);
        $manager->persist($orga2);

        $checkpoint = new Checkpoint();
        $checkpoint->setName("checkpoint 01");
        $checkpoint->setAddress("10 rue du test");
        $checkpoint->setCity("Paris");
        $manager->persist($checkpoint);

        $checkpoint2 = new Checkpoint();
        $checkpoint2->setName("checkpoint 02");
        $checkpoint2->setAddress("22 avenue fixture");
        $checkpoint2->setCity("Lyon");
        $manager->persist($checkpoint2);

        $manager->flush();
    }
}
