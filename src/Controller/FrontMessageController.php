<?php

namespace App\Controller;

use App\Entity\FrontMessage;
use App\Form\FrontMessageType;
use App\Repository\FrontMessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/frontmessage")
 */
class FrontMessageController extends AbstractController
{
    /**
     * @Route("/", name="front_message_index", methods={"GET"})
     */
    public function index(FrontMessageRepository $frontMessageRepository): Response
    {
        return $this->render('front_message/index.html.twig', [
            'front_messages' => $frontMessageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="front_message_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $frontMessage = new FrontMessage();
        $form = $this->createForm(FrontMessageType::class, $frontMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($frontMessage);
            $entityManager->flush();

            return $this->redirectToRoute('front_message_index');
        }

        return $this->render('front_message/new.html.twig', [
            'front_message' => $frontMessage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="front_message_show", methods={"GET"})
     */
    public function show(FrontMessage $frontMessage): Response
    {
        return $this->render('front_message/show.html.twig', [
            'front_message' => $frontMessage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="front_message_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, FrontMessage $frontMessage): Response
    {
        $form = $this->createForm(FrontMessageType::class, $frontMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('front_message_index');
        }

        return $this->render('front_message/edit.html.twig', [
            'front_message' => $frontMessage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="front_message_delete", methods={"DELETE"})
     */
    public function delete(Request $request, FrontMessage $frontMessage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$frontMessage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($frontMessage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('front_message_index');
    }
}
