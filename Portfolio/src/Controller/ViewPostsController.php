<?php

namespace App\Controller;

use App\Entity\AddPost;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ViewPostsController extends Controller
{
    /**
     * @Route("/view/posts", name="view_posts")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showPosts()
    {

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository(AddPost::class);
        $listArticles = $repository->findAll();

            return $this->render('view_posts/index.html.twig', array(
                'listArticles' => $listArticles
            ));
    }
}
