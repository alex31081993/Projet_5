<?php

namespace App\Controller;

use App\Entity\Comment;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ModerationController extends Controller
{
    /**
     * @Route("/moderation", name="moderation")
     */
    public function index()
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository(Comment::class);
        $comments = $repository->findBy([
            'report' => null,
        ]);

        return $this->render('moderation/index.html.twig', [
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("/moderation/remove/{id}", name="remove")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function remove($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $comment = $entityManager->getRepository(Comment::class)->find($id);

        $entityManager->remove($comment);
        $entityManager->flush();


        return $this->redirectToRoute('moderation');
    }

    /**
     * @Route("/moderation/validate/{id}", name="validate")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function validate($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $comment = $entityManager->getRepository(Comment::class)->find($id);

        $comment->setReport(1);
        $entityManager->flush();

        return $this->redirectToRoute('moderation');

    }
}
