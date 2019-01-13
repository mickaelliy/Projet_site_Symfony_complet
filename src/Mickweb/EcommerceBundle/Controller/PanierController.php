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
use Mickweb\EcommerceBundle\Twig\Extension;

class PanierController extends Controller
{
/***********************************************************************************************/
   /**************************** Menu panier ************************************/
   public function menuAction(Request $request)
   {
      $session = $request->getSession();
      if (!$session->has('panier')) 
            $article = 0;
      else
            $article = count($session->get('panier'));

      return $this->render('@MickwebEcommerce/Panier/modulesUsed/panier.html.twig', array('article' => $article));
   }
      
      /**************************** Menu panier ************************************/
    public function panierAction(Request $request)
    {
          $session = $request->getSession();
          if (!$session->has('panier')) $session->set('panier', array());

          $em = $this->getDoctrine()->getManager();
          $produits = $em->getRepository('MickwebEcommerceBundle:Product')->findArray(array_keys($session->get('panier')));
          
          //var_dump($session->get('panier'));
          //die();
      
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

    /**************************** ajouter panier ************************************/  
    public function ajouterAction($id, Request $request)
    {
          $session = $request->getSession();

          if (!$session->has('panier')) $session->set('panier', array());
          $panier = $session->get('panier');

          if(array_key_exists($id, $panier)) {
                if ($request->query->get('qte') != null) $panier[$id] = $request->query->get('qte');
                //$this->get('session')->getFlashBag()->add('success', 'quantité modifiée avec succès');
          } else {
                if ($request->query->get('qte') != null)
                  $panier[$id] = $request->query->get('qte');
                else
                  $panier[$id] = 1;

                
          }

          $session->set('panier', $panier);
          $this->get('session')->getFlashBag()->add('success', 'Article ajouté avec succès');

          return $this->redirect($this->generateUrl('mickweb_ecommerce_panier'));
    }

    
    /**************************** supprimer panier ************************************/  
    public function supprimerAction($id, Request $request)
    {
          $session = $request->getSession();
          $panier = $session->get('panier');

          if (array_key_exists($id, $panier)) {
                unset($panier[$id]);
                $session->set('panier', $panier);
                // permet d'afficher message de suppression
                $this->get('session')->getFlashBag()->add('success', 'Article supprimé avec succès');
          }

          return $this->redirect($this->generateUrl('mickweb_ecommerce_panier'));
    }
}
