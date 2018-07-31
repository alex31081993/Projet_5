<?php

namespace App\Controller;

use App\Entity\AddPost;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ViewPostController extends Controller
{

    /**
     * @Route("/post/{id}", name="view_post")
     * @param Request $request
     * @param $id
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showPost(Request $request, $id, EntityManagerInterface $em)
    {
        $post = $this->getDoctrine()
            ->getRepository(AddPost::class)
            ->find($id);

        $comment = new comment();
        $comment->setCategory($post);
        $ids = $comment->getCategory();

        $comments = $this->getDoctrine()
            ->getRepository(Comment::class)
            ->findBy(array('category' => $ids));


        $form = $this->createFormBuilder($comment)
            ->add('nom', TextType::class)
            ->add('content', TextareaType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $em->persist($comment);
            $em->persist($post);
            $em->flush();

        }
        return $this->render('view_post/index.html.twig', array(
            'form' => $form->createView(),
            'post' => $post,
            'comments' => $comments
        ));
    }
}
