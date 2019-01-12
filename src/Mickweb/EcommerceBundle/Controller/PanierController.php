<?php

namespace Mickweb\EcommerceBundle\Controller;

use Mickweb\EcommerceBundle\Entity\Product;
use Mickweb\EcommerceBundle\Entity\Image;
use Mickweb\EcommerceBundle\Entity\Avis;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class PanierController extends Controller
{
/***********************************************************************************************/
    public function panierAction(Request $request)
    {
          $session = $request->getSession();
          if (!$session->has('panier')) $session->set('panier', array());

          $em = $this->getDoctrine()->getManager();
          $produits = $em->getRepository('MickwebEcommerceBundle:Product')->findArray(array_keys($session->get('panier')));

      
          return $this->render('@MickwebEcommerce/Panier/panier.html.twig', array('produits' => $produits, 
                                                                                  'panier' => $session->get('panier')));
    }

    /**************************** Livraison ************************************/
    public function livraisonAction()
    {
          return $this->render('@MickwebEcommerce/Panier/livraison.html.twig');
    }

    /**************************** Validation ************************************/
    public function validationAction()
    {
          return $this->render('@MickwebEcommerce/Panier/validation.html.twig');
    }

    public function ajouterAction($id, Request $request)
    {
          $session = $request->getSession();

          if (!$session->has('panier')) $session->set('panier', array());
          $panier = $session->get('panier');

          if(array_key_exists($id, $panier)) {
                if ($request->query->get('qte') != null) $panier[$id] = $request->query->get('qte');
          } else {
                if ($request->query->get('qte') != null)
                  $panier[$id] = $request->query->get('qte');
                else
                  $panier[$id] = 1;
          }

          $session->set('panier', $panier);

          return $this->redirect($this->generateUrl('mickweb_ecommerce_panier'));
    }
}
