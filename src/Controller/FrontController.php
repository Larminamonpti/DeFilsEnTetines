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

//    /**
//     * @Route("/classeur", name="classeur")
//     */
//    public function classeur(ProductsRepository $productsRepository): Response
//    {
//
//        return $this->render('front/produits.html.twig', [
//            'products' => $productsRepository->findBy(['type' => 'Classeur de coloriage']),
//            'title' => 'Classeur de coloriage'
//        ]);
//    }
//    /**
//     * @Route("/panier", name="panier")
//     */
//    public function panier(ProductsRepository $productsRepository): Response
//    {
//
//        return $this->render('front/produits.html.twig', [
//            'products' => $productsRepository->findBy(['type' => 'Panier naissance']),
//            'title' => 'Panier naissance'
//        ]);
//    }
//    /**
//     * @Route("/sac", name="sac")
//     */
//    public function sac(ProductsRepository $productsRepository): Response
//    {
//
//        return $this->render('front/produits.html.twig', [
//            'products' => $productsRepository->findBy(['type' => 'Sac a langer']),
//            'title' => 'Sac a langer'
//        ]);
//    }
//    /**
//     * @Route("/pochette", name="pochette")
//     */
//    public function pochette(ProductsRepository $productsRepository): Response
//    {
//
//        return $this->render('front/produits.html.twig', [
//            'products' => $productsRepository->findBy(['type' => 'Pochette  à couche']),
//            'title' => 'Pochette  à couche'
//        ]);
//    }
//    /**
//     * @Route("/gigoteuse", name="gigoteuse")
//     */
//    public function gigoteuse(ProductsRepository $productsRepository): Response
//    {
//
//        return $this->render('front/produits.html.twig', [
//            'products' => $productsRepository->findBy(['type' => 'Gigoteuse']),
//            'title' => 'Gigoteuse'
//        ]);
//    }
//    /**
//     * @Route("/coussin", name="coussin")
//     */
//    public function coussin(ProductsRepository $productsRepository): Response
//    {
//
//        return $this->render('front/produits.html.twig', [
//            'products' => $productsRepository->findBy(['type' => 'Coussin musicale']),
//            'title' => 'Coussin musicale'
//        ]);
//    }
//    /**
//     * @Route("/lingette", name="lingette")
//     */
//    public function lingette(ProductsRepository $productsRepository): Response
//    {
//
//        return $this->render('front/produits.html.twig', [
//            'products' => $productsRepository->findBy(['type' => 'Lingettes  lavable']),
//            'title' => 'Lingettes  lavable'
//        ]);
//    }
//    /**
//     * @Route("/bavoir", name="bavoir")
//     */
//    public function bavoir(ProductsRepository $productsRepository): Response
//    {
//
//        return $this->render('front/produits.html.twig', [
//            'products' => $productsRepository->findBy(['type' => 'Bavoir']),
//            'title' => 'Bavoir'
//        ]);
//    }
//    /**
//     * @Route("/tapis", name="tapis")
//     */
//    public function tapis(ProductsRepository $productsRepository): Response
//    {
//
//        return $this->render('front/produits.html.twig', [
//            'products' => $productsRepository->findBy(['type' => 'Tapis  à langer']),
//            'title' => 'Tapis  à langer'
//        ]);
//    }
//    /**
//     * @Route("/tetines", name="tetines")
//     */
//    public function tetines(ProductsRepository $productsRepository): Response
//    {
//
//        return $this->render('front/produits.html.twig', [
//            'products' => $productsRepository->findBy(['type' => 'Accroche tétine']),
//            'title' => 'Accroche tétine'
//        ]);
//    }
//    /**
//     * @Route("/cape", name="cape")
//     */
//    public function cape(ProductsRepository $productsRepository): Response
//    {
//
//        return $this->render('front/produits.html.twig', [
//            'products' => $productsRepository->findBy(['type' => 'Cape de bain']),
//            'title' => 'Cape de bain'
//        ]);
//    }
//    /**
//     * @Route("/monnaie", name="monnaie")
//     */
//    public function monnaie(ProductsRepository $productsRepository): Response
//    {
//
//        return $this->render('front/produits.html.twig', [
//            'products' => $productsRepository->findBy(['type' => 'Porte Monnaie']),
//            'title' => 'Porte Monnaie'
//        ]);
//    }
//    /**
//     * @Route("/trousse", name="trousse")
//     */
//    public function trousse(ProductsRepository $productsRepository): Response
//    {
//
//        return $this->render('front/produits.html.twig', [
//            'products' => $productsRepository->findBy(['type' => 'Trousse']),
//            'title' => 'Trousse'
//        ]);
//    }
//

}
