<?php

namespace App\Controller;


use App\Entity\Products;
use App\Entity\Type;

use App\Repository\CategoryRepository;
use App\Repository\ProductsRepository;

use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="front_index")
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

    /**
     * @Route("/produits/{slug}/{id}", name="front_produit", methods={"GET"})
     */
    public function produit(Products $product): Response
    {
        return $this->render('front/produit.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @route ("/menu", name="front_menu")
     */
    public function menu(TypeRepository $typeRepository, CategoryRepository $categoryRepository)
    {
        $menu = [];
        foreach($categoryRepository->findAll() as $categorie) {
            $menu[$categorie->getName()] = $typeRepository->findBy([
                'category' => $categorie->getId()
            ]);
        }

            return $this->render('menu.html.twig', [
                'categories' => $menu
            ]);
        }

    /**
     * @route ("/footer", name="front_footer")
     */
    public function footer(TypeRepository $typeRepository, CategoryRepository $categoryRepository)
    {
        $menu = [];
        foreach($categoryRepository->findAll() as $categorie) {
            $menu[$categorie->getName()] = $typeRepository->findBy([
                'category' => $categorie->getId()
            ]);
        }

            return $this->render('footer.html.twig', [
                'categories' => $menu
            ]);
        }

    


}
