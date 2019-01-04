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
    public function panierAction()
    {
          return $this->render('@MickwebEcommerce/Panier/panier.html.twig');
    }

    public function livraisonAction()
    {
          return $this->render('@MickwebEcommerce/Panier/livraison.html.twig');
    }
}
