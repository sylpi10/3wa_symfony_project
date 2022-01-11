<?php

namespace App\Controller;

use App\Repository\ProducteurRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
    public function index(): Response
    {
        $producteurs = $this->repo->findAll();
        return $this->render('producteur/index.html.twig', [
            'producteurs' => $producteurs,
        ]);
    }
}
