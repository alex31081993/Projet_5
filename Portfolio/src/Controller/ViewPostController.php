<?php

namespace App\Controller;

use App\Entity\AddPost;
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
}
