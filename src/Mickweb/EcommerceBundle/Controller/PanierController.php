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
use Mickweb\EcommerceBundle\Entity\UtilisateursAdresse;
use Mickweb\EcommerceBundle\Form\UtilisateursAdresseType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Mickweb\EcommerceBundle\Entity\Commande;

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

    /**************************** Adresse suppression ************************************/
    public function adresseSuppressionAction($id)
    {
          $em = $this->getDoctrine()->getManager();
          $entity = $em->getRepository('MickwebEcommerceBundle:UtilisateursAdresse')->find($id);

          if ($this->container->get('security.token_storage')->getToken()->getUser() != $entity->getUser() || !$entity) {
            return $this->redirect($this->generateUrl('mickweb_ecommerce_livraison'));
          }

          $em->remove($entity);
          $em->flush();
            // $request->getSession()->getFlashBag()->add('info', 'Adresse bien supprimée.');

          return $this->redirect($this->generateUrl('mickweb_ecommerce_livraison'));
    }

    /**************************** Livraison ************************************/
    public function livraisonAction(Request $request)
    {
      //     $entity = new UtilisateursAdresse();
      //     $form = $this->createForm(new UtilisateursAdresseType(), $entity);

      //     return $this->render('@MickwebEcommerce/Panier/livraison.html.twig', array('form' => $form->createView()));

      $user = $this->container->get('security.token_storage')->getToken()->getUser();
      $entity = new UtilisateursAdresse();
      $form = $this->get('form.factory')->create(UtilisateursAdresseType::class, $entity);

      if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){

            $em = $this->getDoctrine()->getManager();
            $entity->setUser($user);
            $em->persist($entity);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'adresse mise à jour.');

            return $this->redirect($this->generateUrl('mickweb_ecommerce_livraison'));
      }
      
      return $this->render('@MickwebEcommerce/Panier/livraison.html.twig', array(
            'user' => $user,
            'form' => $form->createView())
      );
    }

    /**************************** Set livraison ************************************/
    public function setLivraisonOnSession(Request $request)
    {
      //      $session = $this->getRequest()->getSession();
           $session = $request->getSession();

          if(!$session->has('adresse')) $session->set('adresse', array());
          $adresse = $session->get('adresse');

          if($this->getRequest()->request->get('livraison') != null && $this->getRequest()->request->get('facturation') != null)
          {
                $adresse['livraison'] = $this->getRequest()->request->get('livraison');
                $adresse['facturation'] = $this->getRequest()->request->get('facturation');
          } else {
                return $this->redirect($this->generateUrl('mickweb_ecommerce_validation'));
          }

          $session->set('adresse', $adresse);
          return $this->redirect($this->generateUrl('mickweb_ecommerce_validation'));
    }

    /**************************** Validation ************************************/
    public function validationAction(Request $request)
    {
          if($request->isMethod('POST'))
          {
                $this->setLivraisonOnSession();
          }
      // renvoie la methode preparecommande du controller "Commandes" 
          $em = $this->getDoctrine()->getManager();
          $prepareCommande = $this->forward('MickwebEcommerceBundle:Commandes:prepareCommande');
          $commande = $em->getRepository('MickwebEcommerceBundle:Commande')->find($prepareCommande->getContent());

          
      //     $session = $this->getRequest()->getSession();
      //     $session = $request->getSession();
      //     $adresse = $session->get('adresse');

      //     $produits = $em->getRepository('MickwebEcommerceBundle:Product')->findArray(array_keys($session->get('panier')));
      //     $livraison = $em->getRepository('MickwebEcommerceBundle:UtilisateursAdresse')->find($adresse['livraison']);
      //     $facturation = $em->getRepository('MickwebEcommerceBundle:UtilisateursAdresse')->find($adresse['facturation']);

          return $this->render('@MickwebEcommerce/Panier/validation.html.twig', array(
                  'commande' => $commande
            //     'produits' => $produits,
            //     'livraison' => $livraison,
            //     'facturation' => $facturation,
            //     'panier' => $session->get('panier')
            ));
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
