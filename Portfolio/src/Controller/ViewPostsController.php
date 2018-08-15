<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ViewPostsController extends Controller
{
    /**
     * @Route("/posts", name="posts")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showPosts()
    {

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository(Post::class);
        $listArticles = $repository->findAll();

            return $this->render('view_posts/index.html.twig', array(
                'listArticles' => $listArticles
            ));
    }
}
