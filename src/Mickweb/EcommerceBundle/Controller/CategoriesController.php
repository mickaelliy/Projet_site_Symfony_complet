<?php

namespace Mickweb\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class CategoriesController extends Controller
{
/***********************************************************************************************/
      public function menuAction()
      {
      $em = $this->getDoctrine()->getManager();
      $pages = $em->getRepository('MickwebEcommerceBundle:Categories')->findAll();

      return $this->render('MickwebPagesBundle:Default:pages/modulesUsed/menu.html.twig', array('pages' => $pages));
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
