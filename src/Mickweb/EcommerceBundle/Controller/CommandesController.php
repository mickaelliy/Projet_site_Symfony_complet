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

class CommandesController extends Controller
{

/***********************************************************************************************/
      public function facture(Request $request)
      {
            $em = $this->getDoctrine()->getManager();
            // $generator = $this->container->get('security.secure_random');
            $generator = random_bytes(20);
            $session = $request->getSession();
            $adresse = $session->get('adresse');
            $panier = $session->get('panier');
            $commande = array();
            $totalHT = 0;
            $totalTTC = 0;
            // $totalTVA = 0;

            $facturation = $em->getRepository('MickwebEcommerceBundle:UtilisateursAdresse')->find($adresse['facturation']);
            $livraison = $em->getRepository('MickwebEcommerceBundle:UtilisateursAdresse')->find($adresse['livraison']);
            $produits = $em->getRepository('MickwebEcommerceBundle:Product')->findArray(array_keys($session->get('panier')));

            foreach($produits as $produit)
            {
                  $prixHT = ($produit->getPrix() * $panier[$produit->getId()]);
                  $prixTTC = ($produit->getPrix() * $panier[$produit->getId()] / $produit->getTva()->getMultiplicate());
                  $totalHT += $prixHT;
                  $totalTTC += $prixTTC;
                  
                  if (!isset($commande['tva']['%'.$produit->getTva()->getValeur()]))
                  {
                        $commande['tva']['%'.$produit->getTva()->getValeur()] = round($prixTTC - $prixHT,2);
                  } else {
                        $commande['tva']['%'.$produit->getTva()->getValeur()] = round($prixTTC - $prixHT,2);
                  }

                  $totalTVA += round($prixTTC - $prixHT,2);

                  $commande['produit'][$produit->getId()] = array('reference' => $produit->getTitre(),
                                                                  'quantite' => $panier[$produit->getId()],
                                                                  'prixHT' => round($produit->getPrix(),2),
                                                                  'prixTTC' => round($produit->getPrix() / $produit->getTva()->getMultiplicate(),2) 
                                                            );
            }

            $commande['livraison'] = array('prenom' => $livraison->getPrenom(),
                                          'nom' => $livraison->getNom(),
                                          'telephone' => $livraison->getTelephone(),
                                          'adresse' => $livraison->getAdresse(),
                                          'cp' => $livraison->getCp(),
                                          'ville' => $livraison->getVille(),
                                          'pays' => $livraison->getPays(),
                                          'complement' => $livraison->getComplement(),
                                    );
            $commande['facturation'] = array('prenom' => $facturation->getPrenom(),
                                          'nom' => $facturation->getNom(),
                                          'telephone' => $facturation->getTelephone(),
                                          'adresse' => $facturation->getAdresse(),
                                          'cp' => $facturation->getCp(),
                                          'ville' => $facturation->getVille(),
                                          'pays' => $facturation->getPays(),
                                          'complement' => $facturation->getComplement(),
                                    );
                                    
            $commande['prixHT'] = round($totalHT,2);
            $commande['prixTTC'] = round($totalTTC,2);
            // $commande['prixTTC'] = round($totalHT + $totalTVA,2);
            $commande['token'] = bin2hex($generator);
            
            return $commande;
      }      
/***********************************************************************************************/
      public function prepareCommandeAction(Request $request)
      {
            $session = $request->getSession();
            $em = $this->getDoctrine()->getManager();

            if (!$session->has('commande'))
            {
                  $commande = new Commandes();
            } else {
                  // $commande = $em->getRepository('MickwebEcommerceBundle:Commandes')->find($session->get('commande'));
                  $commande = $session->get('commande');
            }

            $commande->setDate(new \DateTime());
            $commande->setUser($this->container->get('security.token_storage')->getToken()->getUser());
            $commande->setValider(0);
            $commande->setReference(0);
            $commande->setCommande($this->facture($request));

            // if (!$session->has('commande')) {
                 
            // }
            $em->persist($commande);
            $session->set('commande', $commande);

            $em->flush();
      
            return new Response($commande->getId());
      }

/***********************************************************************************************/
      public function validationCommandeAction($id, Request $request)
      {
            $em = $this->getDoctrine()->getManager();
            $commande = $em->getRepository('MickwebEcommerceBundle:Commandes')->find($id);
            
            if (!$commande || $commande->getValider() == 1)
                  throw $this->createNotFoundException('La commande n\'existe pas');
            
            $commande->setValider(1);
            $commande->setReference($this->container->get('setNewReference')->reference()); //on appelle le Service
            $em->flush();   
            
            $session = $request->getSession();
            $session->remove('adresse');
            $session->remove('panier');
            $session->remove('commande');
            
            $this->get('session')->getFlashBag()->add('success','Votre commande est validée avec succès');
            // return $this->redirect($this->generateUrl('mickweb_ecommerce_homepage'));
            return $this->redirect($this->generateUrl('mickweb_user_factures'));
      }

/***********************************************************************************************/
      
}
