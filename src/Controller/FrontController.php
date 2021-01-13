<?php

namespace App\Controller;


use App\Entity\Products;
use App\Entity\Type;
use App\Repository\AboutMeRepository;
use App\Repository\CategoryRepository;
use App\Repository\ImagesRepository;
use App\Repository\PanierRepository;
use App\Repository\ProductsRepository;

use App\Repository\TypeRepository;
use App\Service\ProductTable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="front_index")
     */
    public function index(AboutMeRepository $aboutMeRepository, ImagesRepository $imagesRepository, PanierRepository $panierRepository, SessionInterface $session): Response
    {
        if(!empty($this->getUser()))
        {
        $userPanier = $panierRepository->findBy(['user' => $this->getUser()])[0]->getPanier();
        }
        $panier = $session->get('panier', []);
        if(!empty($userPanier) && (empty($panier))){
            $session->set('panier', $userPanier);
        }
        return $this->render('front/index.html.twig', [
            'images' => $imagesRepository->findFive(),
            'me' => $aboutMeRepository->findBy(['id' => 1])

        ]);
    }

    /**
     * @Route ("/produits/{slug}", name="front_produits")
     */
    public function produits(Type $type, ProductsRepository $productsRepository, ImagesRepository $imagesRepository, ProductTable $productTable, $slug)
    {
        return $this->render('front/produits.html.twig', [
            'products' => $productTable->getTableBy($productsRepository, $imagesRepository, $type),
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


