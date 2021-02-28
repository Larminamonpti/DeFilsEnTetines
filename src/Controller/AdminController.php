<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Images;
use App\Entity\Products;
use App\Entity\Type;
use App\Entity\AboutMe;
use App\Entity\FrontMessage;
use App\Entity\Commande;
use App\Form\CategoryType;
use App\Form\ProductsType;
use App\Form\TypeType;
use App\Form\AboutMeType;
use App\Form\ImagesType;
use App\Form\FrontMessageType;
use App\Repository\CategoryRepository;
use App\Repository\CommandeRepository;
use App\Repository\ImagesRepository;
use App\Repository\ProductsRepository;
use App\Repository\TypeRepository;
use App\Service\ProductTable;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route ("/", name="admin_index")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/products/", name="products_index", methods={"GET"})
     */
    public function productsIndex(ProductsRepository $productsRepository, ImagesRepository $imagesRepository, ProductTable $productTable): Response
    {
    
        return $this->render('admin/products/index.html.twig', [
            'products' => $productTable->getTableAll($productsRepository, $imagesRepository)
        ]);
    }

    /**
     * @Route("/products/new", name="products_new", methods={"GET","POST"})
     */
    public function productsNew(Request $request): Response
    {
        $product = new Products();
        $images = new Images();
        $product->addImage($images);
        $form = $this->createForm(ProductsType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('products_index');
        }

        return $this->render('admin/products/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/products/{id}/edit", name="products_edit", methods={"GET","POST"})
     */
    public function productsEdit(Request $request, Products $product, ImagesRepository $imagesRepository): Response
    {
        

        $form = $this->createForm(ProductsType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('products_index');
        }

        return $this->render('admin/products/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/products/{id}", name="products_delete", methods={"DELETE"})
     */
    public function productsDelete(Request $request, Products $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('products_index');
    }

    /**
     * @Route("/category/", name="category_index", methods={"GET"})
     */
    public function CategoryIndex(CategoryRepository $categoryRepository): Response
    {
        return $this->render('admin/category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/category/new", name="category_new", methods={"GET","POST"})
     */
    public function CategoryNew(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('category_index');
        }

        return $this->render('admin/category/new.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/category/{id}/edit", name="category_edit", methods={"GET","POST"})
     */
    public function CategoryEdit(Request $request, Category $category): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('category_index');
        }

        return $this->render('admin/category/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/category/{id}", name="category_delete", methods={"DELETE"})
     */
    public function CategoryDelete(Request $request, Category $category): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('category_index');
    }

    /**
     * @Route("/type/", name="type_index", methods={"GET"})
     */
    public function TypeIndex(TypeRepository $typeRepository): Response
    {
        return $this->render('admin/type/index.html.twig', [
            'types' => $typeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/type/new", name="type_new", methods={"GET","POST"})
     */
    public function TypeNew(Request $request): Response
    {
        $type = new Type();
        $form = $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($type);
            $entityManager->flush();

            return $this->redirectToRoute('type_index');
        }

        return $this->render('admin/type/new.html.twig', [
            'type' => $type,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/type/{id}/edit", name="type_edit", methods={"GET","POST"})
     */
    public function TypeEdit(Request $request, Type $type): Response
    {
        $form = $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('type_index');
        }

        return $this->render('admin/type/edit.html.twig', [
            'type' => $type,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/type/{id}", name="type_delete", methods={"DELETE"})
     */
    public function TypeDelete(Request $request, Type $type): Response
    {
        if ($this->isCsrfTokenValid('delete'.$type->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($type);
            $entityManager->flush();
        }

        return $this->redirectToRoute('type_index');
    }
    
    /**
     * @Route("/aboutme/{id}/edit", name="aboutMe_edit", methods={"GET","POST"})
     */
    public function AboutMeEdit(Request $request, AboutMe $aboutMe, ImagesRepository $imagesRepository): Response
    {
        $aboutMe->setImages($imagesRepository->findOneBy(['id' => $aboutMe->getImages()]));
        $form = $this->createForm(AboutMeType::class, $aboutMe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/about_me/edit.html.twig', [
            'about_me' => $aboutMe,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/frontmessage/{id}/edit", name="front_message_edit", methods={"GET","POST"})
     */
    public function FrontMessageEdit(Request $request, FrontMessage $frontMessage): Response
    {
        $form = $this->createForm(FrontMessageType::class, $frontMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/front_message/edit.html.twig', [
            'front_message' => $frontMessage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/commande/encours", name="commande_en_cours", methods={"GET"})
     */
    public function CommandeEnCours(CommandeRepository $commandeRepository){

        return $this->render('admin/commande/enCours.html.twig', [
            
            'commandes' => $commandeRepository->findBy(['send' => false]),
            
        ]);
    }
    /**
     * @Route("/commande/sended", name="commande_sended", methods={"GET",})
     */
    public function CommandeSend(CommandeRepository $commandeRepository){

        return $this->render('admin/commande/enCours.html.twig', [
            
            'commandes' => $commandeRepository->findBy(['send' => true]),
            
        ]);
    }
    /**
     * @Route("/commande/encours/{id}", name="commande_update", methods={"GET","POST"})
     */
    public function updateCommande(Commande $commande){

        $commande->setSend(true);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($commande);
        $entityManager->flush();
        
        
        return $this->redirectToRoute('commande_en_cours');
    }

}

    