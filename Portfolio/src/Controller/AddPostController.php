<?php

namespace App\Controller;

use App\Entity\AddPost;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AddPostController extends Controller
{
    /**
     * @Route("/post", name="post")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, EntityManagerInterface $em)
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
            $em->persist($post);
            $em->flush();

        }

        return $this->render('add_post/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
