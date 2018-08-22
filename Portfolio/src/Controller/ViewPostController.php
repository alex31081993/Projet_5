<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Comment;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use ReCaptcha\ReCaptcha;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ViewPostController extends Controller
{

    /**
     * @Route("/post/{id}", name="post")
     * @param Request $request
     * @param $id
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showPost(Request $request, $id, EntityManagerInterface $em)
    {
        $recaptcha = new ReCaptcha('6LdJ12AUAAAAAMfBSWY7TG6Oh0ByZSvfO8fkdWSe');
        $resp = $recaptcha->verify($request->request->get('g-recaptcha-response'), $request->getClientIp());
        $post = $this->getDoctrine()
            ->getRepository(Post::class)
            ->find($id);


        $comments = $post->getComments();


        $form = $this->createForm(CommentType::class, new Comment());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $resp->isSuccess()) {
            $comment = $form->getData();
            $comment->setCategory($post);
            $em->persist($comment);
            $em->flush();

        }
        return $this->render('view_post/index.html.twig', array(
            'form' => $form->createView(),
            'post' => $post,
            'comments' => $comments
        ));
    }
}
