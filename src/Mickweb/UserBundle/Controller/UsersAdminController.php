<?php

namespace Mickweb\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class UsersAdminController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $utilisateurs = $em->getRepository('MickwebUserBundle:User')->findAll();
        
        return $this->render('MickwebUserBundle:Administration:Users/layout/index.html.twig', array('utilisateurs' => $utilisateurs));
    }
    
    public function utilisateurAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $utilisateur = $em->getRepository('MickwebUserBundle:User')->find($id);
        $route = $request->get('_route');
        
        if ($route == 'adminAdressesUsers')
            return $this->render('MickwebUserBundle:Administration:Users/layout/adresses.html.twig', array('utilisateur' => $utilisateur));
        else if ($route == 'adminFacturesUsers')
            return $this->render('MickwebUserBundle:Administration:Users/layout/factures.html.twig', array('utilisateur' => $utilisateur));
        else 
            throw $this->createNotFoundException('La vue n\'existe pas.');
    }
}