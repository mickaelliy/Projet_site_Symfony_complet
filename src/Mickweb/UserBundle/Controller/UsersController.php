<?php

namespace Mickweb\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Spipu\Html2Pdf\Html2Pdf;

class UsersController extends Controller
{
    public function factureAction()
    {
        $em = $this->getDoctrine()->getManager();
        $factures = $em->getRepository('MickwebEcommerceBundle:Commandes')->byFacture($this->getUser());
        
        return $this->render('MickwebUserBundle:Default:layout/facture.html.twig', array('factures' => $factures));
    }

    public function facturePDFAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $facture = $em->getRepository('MickwebEcommerceBundle:Commandes')->findOneBy(array('user' => $this->getUser(),
                                                                                            'valider' => 1,
                                                                                            'id' => $id
                                                                                        ));
        if(!$facture) {
            $this->get('session')->getFlashBag()->add('error', 'Une erreur est survenue');
            return $this->redirect($this->generateUrl('mickweb_user_factures'));
        }

        // $html = $this->renderView('MickwebUserBundle:Default:layout/facturePDF.html.twig', array('facture' => $facture));
        
        // $html2pdf = new Html2Pdf('P','A4','fr');
        // $html2pdf->pdf->SetAuthor('Raaaaats');
        // $html2pdf->pdf->SetTitle('Facture '.$facture->getReference());
        // $html2pdf->pdf->SetSubject('Facture Raaaaats');
        // $html2pdf->pdf->SetKeywords('facture,raaaaats');
        // $html2pdf->pdf->SetDisplayMode('real');
        // $html2pdf->writeHTML($html);
        // $html2pdf->Output('Facture.pdf');
         
        // $response = new Response();
        // $response->headers->set('Content-type' , 'application/pdf');
        
        // return $response;

        // Le service getFacture permet de générer la facture
        $this->container->get('setNewFacture')->facture($facture);

    }
    
}