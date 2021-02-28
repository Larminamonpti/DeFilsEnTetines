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
