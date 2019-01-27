<?php

namespace Mickweb\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoriesController extends Controller
{
/***********************************************************************************************/
      public function menuAction()
      {
      $em = $this->getDoctrine()->getManager();
      $categories = $em->getRepository('MickwebEcommerceBundle:Category')->findAll();

      return $this->render('MickwebEcommerceBundle:Categories:modulesUsed/menu.html.twig', array('categories' => $categories));
      }

/***********************************************************************************************/
      public function pageAction($id)
      {
      $em = $this->getDoctrine()->getManager();
      $page = $em->getRepository('MickwebPagesBundle:Pages')->find($id);

      if (null === $page) {
            throw new NotFoundHttpException("La page" .$id. "n'existe pas");
            }

      return $this->render('MickwebPagesBundle:Default:pages/layout/page.html.twig', array('page' => $page));
      }
}
