<?php

namespace App\Controller;

use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ModerationController extends Controller
{
    /**
     * @Route("/moderation", name="moderation")
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(EntityManagerInterface $entityManager)
    {
        $repository = $entityManager
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
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function remove($id, EntityManagerInterface $entityManager)
    {
        $comment = $entityManager->getRepository(Comment::class)->find($id);

        $entityManager->remove($comment);
        $entityManager->flush();

        return $this->redirectToRoute('moderation');
    }

    /**
     * @Route("/moderation/validate/{id}", name="validate")
     * @param $id
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function validate($id, EntityManagerInterface $entityManager)
    {
        $comment = $entityManager->getRepository(Comment::class)->find($id);

        $comment->setReport(1);
        $entityManager->flush();

        return $this->redirectToRoute('moderation');

    }
}
