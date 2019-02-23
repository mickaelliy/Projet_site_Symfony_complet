<?php

namespace Mickweb\EcommerceBundle\Notification;

use Mickweb\EcommerceBundle\Entity\Contact;

class ContactNotification {

    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    
    /**
     * @var Environment
     */
    private $renderer;
    
    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function notify(Contact $contact)
    {
        $message = (new \Swift_Message('Question client :' . $contact->getProduct()->getTitre() ))
            ->setFrom('noreply@server.com')
            ->setTo('mickael.lizeray@gmail.com')
            ->setReplyTo($contact->getEmail())
            ->setBody($this->renderer->render('Emails/contacts.html.twig', array(
                'contact' => $contact
            )), 'text/html');
            $this->mailer->send($message);
    }
}

   