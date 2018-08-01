<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class FrontendController extends Controller
{
    /**
     * @Route("/index", name="index")
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(UserPasswordEncoderInterface $encoder)
    {
        // whatever *your* User object is
        $user = new User();
        $plainPassword = 'alex';
        $encoded = $encoder->encodePassword($user, $plainPassword);

        $user->setPassword($encoded);
        var_dump($user);

        return $this->render('frontend/index.html.twig', [
            'controller_name' => 'FrontendController',
        ]);
    }


}
