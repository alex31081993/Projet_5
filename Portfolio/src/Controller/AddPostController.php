<?php

namespace App\Controller;

use App\Entity\AddPost;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AddPostController extends Controller
{
    /**
     * @Route("/post", name="add_post")
     */
    public function index(Request $request)
    {
        $post = new AddPost();

        $form = $this->createFormBuilder($post)
            ->add('titre', TextType::class)
            ->add('chapo', TextType::class)
            ->add('content', TextareaType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

        }

        return $this->render('add_post/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
