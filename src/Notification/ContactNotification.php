<?php
namespace App\Notification;

use App\Entity\Contact;
use Twig\Environment;


class ContactNotification{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer ){
        $this->mailer = $mailer;
        $this->renderer = $renderer;

    }
    public function notify(Contact $contact) { // Permet d envoyer un email
        $message = (new \Swift_Message('Email utilisateur : ' . $contact->getEmail()))
            ->setFrom($contact->getEmail())
            ->setTo('rayrayallen20192018@gmail.com')
            ->setReplyTo($contact->getEmail())
            ->setBody($this->renderer->render('email/contact.html.twig', [
                'contact' => $contact
            ]), 'text/html');
        $this->mailer->send($message); 
       }
}