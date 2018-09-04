<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Handler\Form\ContactFormHandler;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ReCaptcha\ReCaptcha;


class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contact")
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @param ContactFormHandler $contactFormHandler
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, \Swift_Mailer $mailer, ContactFormHandler $contactFormHandler)
    {
        $recaptcha = new ReCaptcha($this->getParameter('secret'));
        $resp = $recaptcha->verify($request->request->get('g-recaptcha-response'), $request->getClientIp());

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && !$contactFormHandler->handle($form, $resp, $mailer)) {
            $this->addFlash('notice1', 'Valider le captcha pour envoyer votre message.');

        }

        return $this->render('contact/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }


}
