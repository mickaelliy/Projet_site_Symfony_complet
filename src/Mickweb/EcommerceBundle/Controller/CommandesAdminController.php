<?php

namespace Mickweb\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Mickweb\EcommerceBundle\Entity\Commandes;
use Mickweb\EcommerceBundle\Entity\UtilisateursAdresse;
use Mickweb\EcommerceBundle\Entity\Product;
use Mickweb\EcommerceBundle\Form\UtilisateursAdresseType;

class CommandesAdminController extends Controller
{

/***********************************************************************************************/

      public function commandesAction()
      {
            // $session = $request->getSession();
            $em = $this->getDoctrine()->getManager();
            $commandes = $em->getRepository('MickwebEcommerceBundle:Commandes')->findAll();

            return $this->render('commandes/index.html.twig', array(
                  'commandes' => $commandes
              ));
      }

/***********************************************************************************************/
      public function validationCommandeAction($id, Request $request)
      {
            $em = $this->getDoctrine()->getManager();
            $commande = $em->getRepository('MickwebEcommerceBundle:Commandes')->find($id);
            
            if (!$commande || $commande->getValider() == 1)
                  throw $this->createNotFoundException('La commande n\'existe pas');
            
            $commande->setValider(1);
            $commande->setReference(1); //Service
            $em->flush();   
            
            $session = $request->getSession();
            $session->remove('adresse');
            $session->remove('panier');
            $session->remove('commande');
            
            $this->get('session')->getFlashBag()->add('success','Votre commande est validée avec succès');
            return $this->redirect($this->generateUrl('mickweb_ecommerce_homepage'));
      }

/***********************************************************************************************/
      public function showFactureAction($id)
      {
            $em = $this->getDoctrine()->getManager();
            $facture = $em->getRepository('MickwebEcommerceBundle:Commandes')->find($id);

            if(!$facture) {
                  $this->get('session')->getFlashBag()->add('error', 'Une erreur est survenue');
                  return $this->redirect($this->generateUrl('adminCommandes_index'));
            }

            // Le service getFacture permet de générer la facture
            $this->container->get('setNewFacture')->facture($facture);
      }

}
