<?php

namespace App\Controller;

use App\Entity\AddPost;
use App\Entity\Comment;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ViewPostController extends Controller
{
    /**
     * @Route("/post/{id}", name="view_post")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showPost($id)
    {
        $repository = $this->getDoctrine()
            ->getRepository(AddPost::class)
            ->find($id);

        return $this->render('view_post/index.html.twig', array(
            'repository' => $repository
        ));

    }
    public function addComment(Request $request)
    {
        $comment = new comment();

        $form = $this->createFormBuilder($comment)
            ->add('nom', TextType::class)
            ->add('content', TextareaType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

        }

        return $this->render('view_post/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
