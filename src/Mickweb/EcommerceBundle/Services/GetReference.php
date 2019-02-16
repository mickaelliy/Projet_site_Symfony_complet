<?php

namespace Mickweb\EcommerceBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class GetReference
{
    public function __construct(TokenStorage $tokenStorage, $entityManager)
    {
        $this->em = $entityManager;
        // $this->securityContext = $container->get('security.context');
        $this->tokenStorage = $tokenStorage;
        // $this->tokenStorage = $container->get('tokenStorage');
    }

    public function reference()
    {
        $reference = $this->em->getRepository('MickwebEcommerceBundle:Commandes')->findOneBy(array('valider' => 1), array('id' => 'DESC'),1,1);

        if(!$reference){
            // si il n'y a pas de référence, donc pas de facture, on retourne 1
            return 1;
        } else {
            // sinon on récupère la dernière ref et on lui rajoute 1
            return $reference->getReference() +1;
        }
    }

}
