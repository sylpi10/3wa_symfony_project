<?php

namespace App\Controller;

use App\Repository\CheckpointRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckpointController extends AbstractController
{
    private CheckpointRepository $repo;

    public function __construct(CheckpointRepository $repo)
    {
        $this->repo = $repo;
    }
    /**
     * @Route("/", name="checkpoint")
     */
    public function index(): Response
    {
        $checkpoints = $this->repo->findAll();

        return $this->render('checkpoint/index.html.twig', [
            'checkpoints' => $checkpoints,
        ]);
    }
}
