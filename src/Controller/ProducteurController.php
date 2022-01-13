<?php

namespace App\Controller;

use App\Entity\FinalUser;
use App\Entity\Producteur;
use App\Form\AcceptCheckpointType;
use App\Repository\ProductRepository;
use App\Repository\ProducteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ProducteurRegistrationFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
     * @Route("/producteur/{id}", name="producteur_detail", methods={"GET", "POST"})
     */
    public function detail(Producteur $producteur, Request $request, EntityManagerInterface $entityManager): Response
    {
        $checkpoints = $producteur->getCheckpoints();
        $accepted = [];
        $refused = [];
        if (count($checkpoints) > 0) {
            foreach ($checkpoints as $check) {
                if (!$check->getIsAccepted()) {
                    $accepted[] = $check;
                }
                if ($check->getIsAccepted()) {
                    $refused[] = $check;
                }
            }
        }

        if ($_POST) {

            foreach ($request->request as $data) {
                if ($data == 'on') {
                    foreach ($producteur->getCheckpoints() as $checkpoint) {
                        $checkpoint->setIsAccepted(true);
                        $entityManager->persist($producteur);
                    }
                }
                $entityManager->flush();
            }
            // return $this->redirectToRoute('producteur_detail', [
            //     'id' => $producteur->getId()
            // ]);

            return $this->redirect('/producteur/' . $producteur->getId());
        }


        return $this->render('producteur/detail.html.twig', [
            'producteur' => $producteur,
            'checkpoints' => $checkpoints,
            'accepted' => $accepted,
            'refused' => $refused,
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
