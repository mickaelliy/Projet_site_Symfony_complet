<?php

namespace Mickweb\PagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PagesController extends Controller
{
    public function menuAction()
    {
        $em = $this->getDoctrine()->getManager();
        $pages = $em->getRepository('MickwebPagesBundle:Pages')->findAll();

        return $this->render('MickwebPagesBundle:Default:pages/modulesUsed/menu.html.twig', array('pages' => $pages));
    }

    public function pageAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository('MickwebPagesBundle:Pages')->find($id);

        if (null === $page) {
            throw new NotFoundHttpException("La page" .$id. "n'existe pas");
          }

        return $this->render('MickwebPagesBundle:Default:pages/layout/page.html.twig', array('page' => $page));
    }

    public function contactFormAction(Product $product)
    {
        $contact = new Contact();
        $contact = setProduct($product);
        $form = $this->createForm(ContactType::class, $contact);

        return $this->render('MickwebPagesBundle:Default:pages/layout/pagecontact.html.twig', array(
            'form' => $form->createView()));
    }
}
