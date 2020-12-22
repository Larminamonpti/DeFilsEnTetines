<?php

namespace App\Controller;

use App\Entity\Products;
use App\Entity\Type;

use App\Repository\ProductsRepository;

use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="front")
     */
    public function index(ProductsRepository $productsRepository, TypeRepository $typeRepository): Response
    {
        return $this->render('front/index.html.twig', [
            'products' => $productsRepository->findFive(),

            'types' => $typeRepository->findAll()
        ]);
    }

    /**
     * @Route ("/produits/{slug}", name="front_produits")
     */
    public function produits(Type $type , ProductsRepository $productsRepository)
    {
        return $this->render('front/produits.html.twig', [
            'products' => $productsRepository->findBy(['type' => $type->getId()]),
            'type' => $productsRepository->findOneBy(['type' => $type->getId()]),

        ]);
    }


}
