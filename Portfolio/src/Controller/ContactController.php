<?php

namespace App\Controller;

use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ReCaptcha\ReCaptcha;


class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contact")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param \Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, EntityManagerInterface $em, \Swift_Mailer $mailer)
    {
        $recaptcha = new ReCaptcha('6LdJ12AUAAAAAMfBSWY7TG6Oh0ByZSvfO8fkdWSe');
        $resp = $recaptcha->verify($request->request->get('g-recaptcha-response'), $request->getClientIp());

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid() && !$resp->isSuccess()) {
            $this->addFlash('notice', 'Valider le captcha pour envoyer votre message.');
        } elseif ($form->isSubmitted() && $form->isValid() && $resp->isSuccess()) {
            $contact = $form->getData();
            $em->persist($contact);
            $em->flush();
            $this->addFlash('notice',
                'message envoyé!');

            $message = (new \Swift_Message ($contact->getSujet()))
                ->setFrom($contact->getEmail())
                ->setTo('alexis.gressier62@gmail.com')
                ->setBody(
                    '<html>' .
                    ' <body>' .
                    '<P>'.
                    'Nom :'.
                    $contact->getNom() .
                    '</P>' .
                    '<p>' .
                    'Email :' .
                    $contact->getEmail() .
                    '</p>' .
                    '  Contenu du message :' .
                    $contact->getContenue() .
                    ' </body>' .
                    '</html>',
                    'text/html'
                );
            $mailer->send($message);

        }

        return $this->render('contact/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }


}
