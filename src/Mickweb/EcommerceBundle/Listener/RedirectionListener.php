<?php

namespace Mickweb\EcommerceBundle\Listener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class RedirectionListener
{
    public function __construct(ContainerInterface $container, Session $session, TokenStorage $tokenStorage)
    {
        $this->session = $session;
        $this->router = $container->get('router');
        // $this->securityContext = $container->get('security.context');
        $this->tokenStorage = $tokenStorage;
        // $this->tokenStorage = $container->get('tokenStorage');
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $route = $event->getRequest()->attributes->get('_route');
        if ($route == 'mickweb_ecommerce_livraison' || $route == 'mickweb_ecommerce_validation') {
            if ($this->session->has('panier')) {
                if (count($this->session->get('panier')) == 0) {
                    $event->setResponse(new RedirectResponse($this->router->generate('panier')));
                }
            }
            if (!is_object($this->tokenStorage->getToken()->getUser())) {
                $this->session->getFlashBag()->add('notification', 'Vous devez vous identifier');
                $event->setResponse(new RedirectResponse($this->router->generate('fos_user_security_login')));
            }
        }
    }

}
