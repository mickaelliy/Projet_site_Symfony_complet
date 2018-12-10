<?php

namespace Mick\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        //return $this->render('@MickWebsite/Default/index.html.twig');

        $content = $this
        	->get('templating')
        	->render('@MickWebsite/Default/index.html.twig', array('nom' => 'Mickael'));

    	return new Response($content);
    }

     public function ficheProduitAction()
    {
        return $this->render('@MickWebsite/Default/fiche_produit.html.twig');
    }
}
