<?php

namespace App\Controller;


use App\Entity\Products;
use App\Entity\Type;
use App\Entity\Panier;
use App\Entity\User;
use App\Entity\Commande;
use App\Entity\Adress;
use App\Form\CommandeType;
use App\Form\UserType;
use App\Repository\AboutMeRepository;
use App\Repository\AdressRepository;
use App\Repository\CategoryRepository;
use App\Repository\FrontMessageRepository;
use App\Repository\ImagesRepository;
use App\Repository\PanierRepository;
use App\Repository\ProductsRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\TypeRepository;
use App\Service\ProductTable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{



    /**
     * @Route("/")
     * @Route("/index", name="front_index")
     */
    public function index(AboutMeRepository $aboutMeRepository, ImagesRepository $imagesRepository, PanierRepository $panierRepository, SessionInterface $session, FrontMessageRepository $frontMessageRepository): Response
    {
        
        if(!empty($this->getUser()) and !empty($panierRepository->findBy(['user' => $this->getUser()])))
        {
        $userPanier = $panierRepository->findBy(['user' => $this->getUser()])[0]->getPanier();
        }
        $panier = $session->get('panier', []);
        if(!empty($userPanier) && (empty($panier))){
            $session->set('panier', $userPanier);
        }
        return $this->render('front/index.html.twig', [
            'images' => $imagesRepository->findFive(),
            'aboutMe' => $aboutMeRepository->findOneBy(['id' => 1]),
            'message' => $frontMessageRepository->findOneBy(['id' => 1]),

        ]);
    }

    /**
     * @Route ("/produits/{slug}", name="front_produits")
     */
    public function produits(Type $type, ProductsRepository $productsRepository, ImagesRepository $imagesRepository, ProductTable $productTable, $slug)
    {

        return $this->render('front/produits.html.twig', [
            'products' => $productTable->getTableBy($productsRepository, $imagesRepository,$type),
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

            /**
     * @Route("/panier", name="panier_index")
     */
    public function panierIndex(SessionInterface $session, ProductsRepository $productsRepository): Response
    {
        
        $panier = $session->get('panier', []);

        $panierPlein = [];
        foreach($panier as $id => $quantity){
            if($productsRepository->find($id)){

                $panierPlein[] = [
                    'product' => $productsRepository->find($id),
                    'quantity' => $quantity
                ];
            }
            }

        $total = 0;
        
        foreach($panierPlein as $item){
    
                $total += ($item['product']->getPrice() * $item['quantity']);
            }
        
        $session->set('total', $total);
        $session->set('panierPlein', $panierPlein);
        return $this->render('front/panier.html.twig', [
            'panier' => $panierPlein,
            'total' => $total,
            'paniers' => $panier
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="panier_add")
     */
    public function panierAdd($id,SessionInterface $session, ProductsRepository $productsRepository, TypeRepository $typeRepository)
    {

        $panier = $session->get('panier', []);

        if(!empty($panier[$id])) {
            $panier[$id]++;
        }else {
            $panier[$id] = 1;
        }

        $typeId = $productsRepository->findOneBy(['id' => $id])->getType()->getId();
        $slug = $typeRepository->findOneBy(['id' => $typeId])->getSlug();

        $session->set('panier', $panier);
        $this->addFlash('rose', 'Article ajouter au panier');
        return $this->redirectToRoute('front_produits', ['slug' => $slug]);
    }

    /**
     * @Route("/panier/remove/{id}" , name="panier_remove")
     */
    public function panierRemove($id, SessionInterface $session)
    {
        $panier = $session->get('panier', []);
        if (!empty($panier[$id])){
            unset( $panier[$id]);
        }
        $session->set('panier', $panier);
        return $this->redirectToRoute('panier_index');
    }

    /**
     * @Route("/panier/remove-one/{id}", name="panier_removeOne")
     */
    public function panierRemoveOne($id, SessionInterface $session)
    {
        $panier = $session->get('panier', []);
        if($panier[$id] == 1){
            unset( $panier[$id]);
        }else{
        $panier[$id] = $panier[$id] - 1;
        }
        $session->set('panier', $panier);
        return $this->redirectToRoute('panier_index');
    }

    /**
     * @Route("/panier/add-one/{id}", name="panier_addOne")
     */
    public function panierAddOne($id, SessionInterface $session)
    {
        $panier = $session->get('panier', []);
        $panier[$id] = $panier[$id] + 1;
        $session->set('panier', $panier);
        return $this->redirectToRoute('panier_index');
    }

    /**
     * @Route("/panier/save", name="panier_save")
     */
    public function PanierSave(SessionInterface $session, PanierRepository $panierRepository){


        $paniers = $panierRepository->findBy(['user' => $this->getUser()])[0];
        $panier = $paniers->getPanier();
        if(!empty($panier))
        {
            $pannierSession = $session->get('panier', []);
            $entityManager = $this->getDoctrine()->getManager();
            $paniers->setPanier($pannierSession);
            $entityManager->flush();
        }else{
        $panier = $session->get('panier', []);
        $pan = new Panier();
        $pan->setPanier($panier);
        $pan->setUser($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($pan);
        $em->flush();
        }
        return $this->redirectToRoute('panier_index');

    }

    /**
     * @Route("/commande", name="commande", methods={"GET", "POST"})
     */
    public function ViewCommande(SessionInterface $session, Request $request){
        $total = $session->get('total');
        $panierPlein = $session->get('panierPlein', []);
        $produits = [];
        
        foreach($panierPlein as  $products){
            $produits[$products['product']->getTitle()] =  $products['quantity'];
        }
        


        $commande  =new Commande();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);
        $commande->setUser($this->getUser())
                ->setProduits($produits)
                ->setTotal($total)
                ->setCreatedAt(new \DateTime())
                ->setSend(false)
                ;

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commande);
            $entityManager->flush();

            return $this->redirectToRoute('front_index');
        }

        return $this->render('front/commande.html.twig', [
            'total' => $total,
            'panier' => $panierPlein,
            'form' => $form->createView(),
            
        ]);

    }


}


