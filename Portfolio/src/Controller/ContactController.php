<?php

namespace App\Controller;

use App\Entity\Contact;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use ReCaptcha\ReCaptcha;


class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request)
    {
        $recaptcha = new ReCaptcha('6LdJ12AUAAAAAMfBSWY7TG6Oh0ByZSvfO8fkdWSe');
        $resp = $recaptcha->verify($request->request->get('g-recaptcha-response'), $request->getClientIp());
        $contact = new contact();

        $form = $this->createFormBuilder($contact)
            ->add('nom', TextType::class)
            ->add('email', TextType::class)
            ->add('sujet', TextType::class)
            ->add('contenue', TextareaType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() &&!$resp->isSuccess()) {
            // Do something if the submit wasn't valid ! Use the message to show something
            $message = "The reCAPTCHA wasn't entered correctly. Go back and try it again." . "(reCAPTCHA said: " . $resp->error . ")";
        }elseif($form->isSubmitted() && $form->isValid() &&$resp->isSuccess()){
            $contact = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
        }

        return $this->render('contact/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }


}
