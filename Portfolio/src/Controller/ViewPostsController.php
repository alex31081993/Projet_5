<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ViewPostsController extends Controller
{
    /**
     * @Route("/posts", name="posts")
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showPosts(EntityManagerInterface $entityManager)
    {

        $repository = $entityManager->getRepository(Post::class);
        $listArticles = $repository->findAll();

            return $this->render('view_posts/index.html.twig', array(
                'listArticles' => $listArticles
            ));
    }

    /**
     * @Route("/posts/remove/{id}", name="removePost")
     * @param $id
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function remove($id , EntityManagerInterface $entityManager)
    {
        $post = $entityManager->getRepository(post::class)->find($id);

        $entityManager->remove($post);

        $entityManager->flush();


        return $this->redirectToRoute('posts');
    }

    /**
     * @Route("/posts/update/{id}", name="updatePost")
     * @param $id
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update($id, Request $request, EntityManagerInterface $em)
    {
        $post = $this->getDoctrine()
            ->getRepository(Post::class)
            ->find($id);

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $em->persist($post);
            $em->flush();

        }

        return $this->render('update_post/index.html.twig', array(
            'form' => $form->createView(),
            'post' => $post,
        ));
    }

}
