<?php

namespace App\Handler\Form;

use Doctrine\ORM\EntityManagerInterface;
use ReCaptcha\Response;
use \Symfony\Component\Form\FormInterface;

class ContactFormHandler
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param FormInterface $form
     * @param Response $resp
     * @param \Swift_Mailer $mailer
     * @return bool
     */
    public function handle(FormInterface $form, Response $resp, \Swift_Mailer $mailer)
    {
        if ($form->isSubmitted() && $form->isValid() && !$resp->isSuccess()) {
               return false;
        } elseif ($form->isSubmitted() && $form->isValid() && $resp->isSuccess()) {
            $contact = $form->getData();
            $this->em->persist($contact);
            $this->em->flush();

            $message = (new \Swift_Message ($contact->getSujet()))
                ->setFrom($contact->getEmail())
                ->setTo('alexis.gressier62@gmail.com')
                ->setBody(
                    '<html>' .
                    '<body>' .
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
                    '</body>' .
                    '</html>',
                    'text/html'
                );
            $mailer->send($message);
            return true;
        }
    }

}