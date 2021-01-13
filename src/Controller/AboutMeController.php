<?php

namespace App\Controller;

use App\Entity\AboutMe;
use App\Form\AboutMeType;
use App\Repository\AboutMeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/aboutme")
 */
class AboutMeController extends AbstractController
{
    /**
     * @Route("/", name="about_me_index", methods={"GET"})
     */
    public function index(AboutMeRepository $aboutMeRepository): Response
    {
        return $this->render('about_me/index.html.twig', [
            'about_mes' => $aboutMeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="about_me_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $aboutMe = new AboutMe();
        $form = $this->createForm(AboutMeType::class, $aboutMe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($aboutMe);
            $entityManager->flush();

            return $this->redirectToRoute('about_me_index');
        }

        return $this->render('about_me/new.html.twig', [
            'about_me' => $aboutMe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="about_me_show", methods={"GET"})
     */
    public function show(AboutMe $aboutMe): Response
    {
        return $this->render('about_me/show.html.twig', [
            'about_me' => $aboutMe,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="about_me_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AboutMe $aboutMe): Response
    {
        $form = $this->createForm(AboutMeType::class, $aboutMe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('about_me_index');
        }

        return $this->render('about_me/edit.html.twig', [
            'about_me' => $aboutMe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="about_me_delete", methods={"DELETE"})
     */
    public function delete(Request $request, AboutMe $aboutMe): Response
    {
        if ($this->isCsrfTokenValid('delete'.$aboutMe->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($aboutMe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('about_me_index');
    }
}
