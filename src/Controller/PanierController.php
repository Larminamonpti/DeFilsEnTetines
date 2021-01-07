<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Repository\PanierRepository;
use App\Repository\ProductsRepository;
use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier_index")
     */
    public function index(SessionInterface $session, ProductsRepository $productsRepository): Response
    {
        
        $panier = $session->get('panier', []);

        $panierPlein = [];
        foreach($panier as $id => $quantity){
            $panierPlein[] = [
                'product' => $productsRepository->find($id),
                'quantity' => $quantity
            ];
        }

        $total = 0;
        foreach($panierPlein as $item){
            $total += ($item['product']->getPrice() * $item['quantity']);
        }

        return $this->render('panier/index.html.twig', [
            'panier' => $panierPlein,
            'total' => $total,
            'paniers' => $panier
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="panier_add")
     */
    public function add($id,SessionInterface $session, ProductsRepository $productsRepository, TypeRepository $typeRepository)
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
    public function remove($id, SessionInterface $session)
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
    public function removeOne($id, SessionInterface $session)
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
    public function addOne($id, SessionInterface $session)
    {
        $panier = $session->get('panier', []);
        $panier[$id] = $panier[$id] + 1;
        $session->set('panier', $panier);
        return $this->redirectToRoute('panier_index');
    }

    /**
     * @Route("/panier/save", name="panier_save")
     */
    public function save(SessionInterface $session, PanierRepository $panierRepository){


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
}


