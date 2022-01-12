<?php

namespace App\Controller;

use App\Entity\Organisateur;
use App\Form\OrganisateurRegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class OrganisateurController extends AbstractController
{
    /**
     * @Route("/organisateur", name= "organisateur")
     *
     * @param Request $request
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function index(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager
    ): Response {

        $organisateur = new Organisateur();
        $form = $this->createForm(OrganisateurRegistrationFormType::class, $organisateur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $organisateur->setPassword(
                $userPasswordHasher->hashPassword(
                    $organisateur,
                    $form->get('plainPassword')->getData()
                )
            );
            $organisateur->setRoles(['ROLE_USER', 'ROLE_ADMIN']);

            $entityManager->persist($organisateur);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('organisateur');
        }

        // $organisateurs = $this->repo->findAll();

        return $this->render('organisateur/index.html.twig', [
            // 'organisateurs' => $organisateurs,
            'registrationForm' => $form->createView(),
        ]);
    }
}