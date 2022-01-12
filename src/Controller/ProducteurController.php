<?php

namespace App\Controller;

use App\Entity\FinalUser;
use App\Entity\Producteur;
use App\Form\ProducteurRegistrationFormType;
use App\Repository\ProducteurRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProducteurController extends AbstractController
{
    private ProducteurRepository $repo;

    public function __construct(ProducteurRepository $repo)
    {
        $this->repo = $repo;
    }
    /**
     * @Route("/producteur", name="producteur")
     */
    public function index(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager
    ): Response {

        $producteur = new Producteur();
        $form = $this->createForm(ProducteurRegistrationFormType::class, $producteur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $producteur->setPassword(
                $userPasswordHasher->hashPassword(
                    $producteur,
                    $form->get('plainPassword')->getData()
                )
            );
            $producteur->setRoles(['ROLE_USER', 'ROLE_PRODUCTEUR']);

            $entityManager->persist($producteur);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('producteur');
        }

        $producteurs = $this->repo->findAll();

        return $this->render('producteur/index.html.twig', [
            'producteurs' => $producteurs,
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/producteur/{id}", name="producteur_detail")
     */
    public function detail(Producteur $producteur): Response
    {
        return $this->render('producteur/detail.html.twig', [
            'producteur' => $producteur,
        ]);
    }
    /**
     * @Route("/producteur/register", name="producteur_register")
     */
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        $producteur = new Producteur();
        $form = $this->createForm(ProducteurRegistrationFormType::class, $producteur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $producteur->setPassword(
                $userPasswordHasher->hashPassword(
                    $producteur,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($producteur);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('checkpoint');
        }

        return $this->render('producteur/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
