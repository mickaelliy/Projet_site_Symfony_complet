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

class BasketController extends Controller
{
/***********************************************************************************************/
    public function indexAction($page)
    {
          return $this->render('@MickwebEcommerce/Product/index.html.twig', array(
            'listProducts' => $listProducts
          ));
    }
}
