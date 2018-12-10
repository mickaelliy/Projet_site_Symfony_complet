<?php

namespace Mickweb\EcommerceBundle\Controller;

use Mickweb\EcommerceBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;


class ProductController extends Controller
{
    public function indexAction($page)
    {
        $listProducts = array(
            array(
              'title'   => 'Tshirt',
              'id'      => 1,
              'author'  => 'Alexandre',
              'content' => 'Tshirt ratifiole metalleux…',
              'date'    => new \Datetime()),
      
            array(
              'title'   => 'Polo',
              'id'      => 2,
              'author'  => 'Hugo',
              'content' => 'Polo avec un vieux monsieur barbu…',
              'date'    => new \Datetime()),
      
            array(
              'title'   => 'Casquette',
              'id'      => 3,  
              'author'  => 'Mathieu',
              'content' => 'Casquette moche mais très chère car elle est oldschool…',
              'date'    => new \Datetime())
          );
      
      
          // Et modifiez le 2nd argument pour injecter notre liste
      
          return $this->render('@MickwebEcommerce/Product/index.html.twig', array(
            'listProducts' => $listProducts
          ));
    }

    public function ficheProduitAction($id)
    {
        $product = array(
            'title'   => 'Tshirt',
            'id'      => 1,
            'author'  => 'Alexandre',
            'content' => 'Tshirt ratifiole metalleux…',
            'date'    => new \Datetime()
        );

        return $this->render('@MickwebEcommerce/Product/fiche_produit.html.twig', array(
            'product' => $product
            ));
    }

    // fonction pour ajouter un produit
    public function ajoutAction(Request $request)
    {
        $product = new Product();
        $product->setTitre('T-shirt Ratifiole');
        $product->setAuteur('Mkl');
        $product->setDescription('T-shirt de qualité. Résiste aux hordes de métalleux, aux Wall of death et Circle pit');
        
        //on récupère l'entityManager
        $em = $this->getDoctrine()->getManager();

        //1ere etape - On persiste l'entité
        $em->persist($product);

        //2eme etape - on flush tout ce qui a été persisté avant
        $em->flush();

        // Metode de récupération des données du formulaire
        if($request->isMethod('POST')){
            $request->getSession()->getFlashBag()->add('notice', 'produit bien enregistré.');
            
            // On redirige vers la page de visualisation du produit
            return $this->redirectToRoute('mickweb_ecommerce_fiche_produit', array('id' => $product->getId()));
        }

        // Si on n'est pas en post, on affiche le formulaire
        return $this->render('@MickwebEcommerce/Product/add.html.twig', array('product' => $product));
    }

    public function modifierAction($id, Request $request)
    {
        if ($request->isMethod('POST')) {

            $request->getSession()->getFlashBag()->add('notice', 'produit bien modifiée.');
            
            return $this->redirectToRoute('mickweb_ecommerce_fiche_produit', array('id' => 5));
    }
        $product = array(
            'title'   => 'Tshirt',
            'id'      => 1,
            'author'  => 'Alexandre',
            'content' => 'Tshirt ratifiole metalleux…',
            'date'    => new \Datetime()
        );

        return $this->render('@MickwebEcommerce/Product/modifier.html.twig', array('product' => $product
        ));
    }

    public function supprimerAction($id)
    {
        return $this->render('@MickwebEcommerce/Product/supprimer.html.twig');
    }

    public function menuAction($limit)
    {
        // On fixe en dur une liste ici, bien entendu par la suite
        // on la récupérera depuis la BDD !

        $listProducts = array(
        array('id' => 2, 'title' => 'T-shirt'),
        array('id' => 5, 'title' => 'Sweats'),
        array('id' => 9, 'title' => 'Casquettes')
        );

        return $this->render('MickwebEcommerceBundle:Product:menu.html.twig', array(

        // Tout l'intérêt est ici : le contrôleur passe
        // les variables nécessaires au template !

        'listProducts' => $listProducts
        ));
    }
}
