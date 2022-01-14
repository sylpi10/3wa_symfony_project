<?php

namespace App\Controller;

use App\Entity\Organisateur;
use App\Form\AssignCheckpointType;
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

            return $this->redirectToRoute('organisateur');
        }

        $assignForm = $this->createForm(AssignCheckpointType::class);
        $assignForm->handleRequest($request);
        if ($assignForm->isSubmitted() && $assignForm->isValid()) {
            $assignedProducteur = $assignForm->get('producteur');
            $assignedCheckpoint =  $assignForm->get('checkpoints');
            foreach ($assignedProducteur->getNormData() as $producteur) {

                foreach ($assignedCheckpoint->getNormData() as $checkpoint) {
                    // $checkpoint->setIsAccepted(false);
                    // if ($checkpoint->getIsAccepted() == true) {
                    //     dd('no');
                    // }
                    $producteur->addCheckpoint($checkpoint);
                }
                $entityManager->persist($producteur);
            }

            // $assignedProducteur->addCheckpoint($assignedCheckpoint);
            // $entityManager->persist($assignedProducteur);
            $entityManager->flush();

            return $this->redirectToRoute('organisateur');
        }
        return $this->render('organisateur/index.html.twig', [
            // 'organisateurs' => $organisateurs,
            'registrationForm' => $form->createView(),
            'assignForm' => $assignForm->createView(),
        ]);
    }
}
