<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Handler\Form\CommentFormHandler;
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
     * @param CommentFormHandler $commentFormHandler
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showPost(Request $request, $id, CommentFormHandler $commentFormHandler)
    {
        $recaptcha = new ReCaptcha($this->getParameter('secret'));
        $resp = $recaptcha->verify($request->request->get('g-recaptcha-response'), $request->getClientIp());
        $post = $this->getDoctrine()
            ->getRepository(Post::class)
            ->find($id);

        $comments = $post->getComments();

        $form = $this->createForm(CommentType::class, new Comment());
        $form->handleRequest($request);

        if (!$commentFormHandler->handle($form, $resp, $post)) {
            $this->addFlash('notice', 'Valider le captcha pour envoyer votre message.');
        }

        return $this->render('view_post/index.html.twig', array(
            'form' => $form->createView(),
            'post' => $post,
            'comments' => $comments
        ));
    }
}
