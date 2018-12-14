<?php

namespace Mickweb\EcommerceBundle\Controller;

use Mickweb\EcommerceBundle\Entity\Product;
use Mickweb\EcommerceBundle\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ProductController extends Controller
{
/*******************************PAGE D'ACCUEIL DES PRODUITS****************************************************************/
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
/*******************************FICHE PRODUIT****************************************************************/
    public function ficheProduitAction($id)
    {
      // Je recupere le repository
      $respository = $this->getDoctrine()
        ->getManager()
        ->getRepository('MickwebEcommerceBundle:Product')
      ;
      // Je recupere l'entité correspondante à l'id $id
      $product= $respository->find($id);

      // $product est donc une instance de Mickweb\EcommerceBundle\Entity\Product
      // ou null si l'id $id n'existe pas
      if (null === $product) {
        throw new NotFoundHttpException("Lannonce d'id" .$id. "n'existe pas");
      }

      return $this->render('@MickwebEcommerce/Product/fiche_produit.html.twig', array(
        'product' => $product
      ));
    }
/*******************************AJOUT PRODUIT****************************************************************/
    // Cette annonation sert à accéder à la page Ajout seulement aux Admin
    // Je l'ai désactivé pour le moment
    ///**
    //* @Security("has_role('ROLE_ADMIN')")
    //*
    //*/

    public function ajoutAction(Request $request)
    {
        // Condition qui donne accès à l'ajout des produits seulement aux ADMIN
        /*if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
          throw new AccessDeniedException('Accès réservé aux administrateurs du site');
        }*/

        // creation de l'entité product
        $product = new Product();
        $product->setTitre('T-shirt Ratifiole');
        $product->setAuteur('Mkl');
        $product->setDescription('T-shirt de qualité. Résiste aux hordes de métalleux, aux Wall of death et Circle pit');

        // creation de l'entité Image
        $image = new Image();
        $image->setUrl('http://sdz-upload.s3.amazonaws.com/prod/upload/job-de-reve.jpg');
        $image->setAlt('Image palmier');

        // On lie l'image à l'annonce
        $product->setImage($image);

        //on récupère l'entityManager
        $em = $this->getDoctrine()->getManager();

        //1ere etape - On persiste l'entité
        $em->persist($product);
        // le fait d'avoir mis cascade "persist", l'entité $image est persisté automatiquement

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

    /*******************************MODIF PRODUIT****************************************************************/
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
