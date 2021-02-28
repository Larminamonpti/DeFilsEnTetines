<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Adress;
use App\Form\UserType;
use App\Form\AdressType;
use App\Repository\AdressRepository;
use App\Repository\CommandeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{

    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
            ]);
        }
        
        /**
         * @Route("/new", name="user_new", methods={"GET","POST"})
         */
        public function newUser(Request $request): Response
        {
            $user = new User();
            $form = $this->createForm(UserType::class, $user, ["isAdmin" => $this->isGranted("ROLE_ADMIN")]);
            $form->handleRequest($request);
        
            if ($form->isSubmitted() && $form->isValid()) {
                $form->getConfig()->getData()->setPassword($this->passwordEncoder->encodePassword($user,$form->getConfig()->getData()->getPassword()));
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
        
                return $this->redirectToRoute('user_index');
            }
        
            return $this->render('front/newUser.html.twig', [
                'user' => $user,
                'form' => $form->createView(),
            ]);
        }
        
    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, AdressRepository $adressRepository, CommandeRepository $commandeRepository): Response
    {
        $adresses = $adressRepository->findby(['user' => $user->getId()]);
        $commandes = $commandeRepository->findBy(['user' => $this->getUser()]);

        $isAdmin = $this->isGranted("ROLE_ADMIN");
        $isUser= $user == $this->getUser();


        if($isAdmin || $isUser) {


        $form = $this->createForm(UserType::class, $user, ["isAdmin" => $this->isGranted("ROLE_ADMIN")]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }


        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'adresses' => $adresses,
            'commandes' => $commandes,
            
        ]);
        }
        return $this->redirectToRoute('front_index');

    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }

}
