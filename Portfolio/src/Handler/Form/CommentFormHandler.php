<?php
/**
 * Created by PhpStorm.
 * User: alexi
 * Date: 31/08/2018
 * Time: 16:39
 */

namespace App\Handler\Form;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use ReCaptcha\Response;
use \Symfony\Component\Form\FormInterface;

class CommentFormHandler
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function handle(FormInterface $form, Response $resp, Post $post)
    {
        if ($form->isSubmitted() && $form->isValid() && !$resp->isSuccess()) {
            return false;

        }
        elseif ($form->isSubmitted() && $form->isValid() && $resp->isSuccess()) {
            $comment = $form->getData();
            $comment->setCategory($post);
            $this->em->persist($comment);
            $this->em->flush();

            return true;
        }
    }
}