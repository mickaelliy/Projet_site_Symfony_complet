<?php

namespace Mickweb\EcommerceBundle\Controller;

use Mickweb\EcommerceBundle\Entity\Product;
use Mickweb\EcommerceBundle\Entity\Image;
use Mickweb\EcommerceBundle\Entity\Avis;
use Mickweb\EcommerceBundle\Entity\Category;
use Mickweb\EcommerceBundle\Entity\tva;
use Mickweb\EcommerceBundle\Entity\Commande;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Mickweb\EcommerceBundle\Form\ProductType;
use Mickweb\EcommerceBundle\Form\ProductModifierType;

class ProductController extends Controller
{
/*******************************PAGE D'ACCUEIL DES PRODUITS****************************************************************/
    public function indexAction($page, Request $request)
    {
          $session = $request->getSession();
          $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('MickwebEcommerceBundle:Product')
          ;
          $listProducts = $repository->myFindAll();

          if($session->has('panier'))
            $panier = $session->get('panier');
          else
            $panier = false;

          return $this->render('@MickwebEcommerce/Product/index.html.twig', array(
            'listProducts' => $listProducts,
            'panier' => $panier
          ));
    }
/*******************************FICHE PRODUIT****************************************************************/
    public function ficheProduitAction($id)
    {
      $em = $this->getDoctrine()->getManager();

      // je recupere le produit l'id
      $product = $em->getRepository('MickwebEcommerceBundle:Product')->find($id);

      // $product est donc une instance de Mickweb\EcommerceBundle\Entity\Product
      // ou null si l'id $id n'existe pas
      if (null === $product) {
        throw new NotFoundHttpException("L'annonce d'id" .$id. "n'existe pas");
      }

      // je recupere la liste des avis de ce produit grace au findBy
      $listAvis = $em
        ->getRepository('MickwebEcommerceBundle:Avis')
        ->findBy(array('product' => $product))
      ;

      return $this->render('@MickwebEcommerce/Product/fiche_produit.html.twig', array(
        'product' => $product,
        'listAvis' => $listAvis
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


        /******************************************
         ******************************************
        // creation de l'entité product
        $product = new Product();
        $product->setTitre('T-shirt Ratifiole');
        $product->setAuteur('Mkl');
        $product->setDescription('T-shirt de qualité. Résiste aux hordes de métalleux, aux Wall of death et Circle pit');

        // Creation d'un 1er avis
        $avis1 = new Avis();
        $avis1->setCommentaire('Super produit, je recommande');
        $avis1->setNote(4);

        // Creation d'un 2eme avis
        $avis2 = new Avis();
        $avis2->setCommentaire('RAwwwww, royal, metal et casse-dalle');
        $avis2->setNote(4);

        // creation de l'entité Image
        $image = new Image();
        $image->setUrl('http://sdz-upload.s3.amazonaws.com/prod/upload/job-de-reve.jpg');
        $image->setAlt('Image palmier');

        // On lie l'image à l'annonce
        $avis1->setProduct($product);
        $avis2->setProduct($product);
        $product->setImage($image);

        //on récupère l'entityManager
        $em = $this->getDoctrine()->getManager();

        //1ere etape - On persiste l'entité
        $em->persist($product);
        $em->persist($avis1);
        $em->persist($avis2);
        // le fait d'avoir mis cascade "persist", l'entité $image est persisté automatiquement

        //2eme etape - on flush tout ce qui a été persisté avant
        $em->flush();

        ****************************************************/



        $product = new Product();

        // Avis en dur dans le code -- à supprimer par la suite
        $avis1 = new Avis();
        $avis1->setCommentaire('Super produit, je recommande');
        $avis1->setNote(4);
        $avis1->setProduct($product);

        // création du formbuilder grace au service form factory
        $form = $this->get('form.factory')->create(ProductType::class, $product);

       /* $formBuilder
            ->add('titre',          TextType::class)
            ->add('description',    TextareaType::class)
            ->add('auteur',         TextType::class)
            ->add('published',      CheckboxType::class, array('required' => false))
            ->add('save',           SubmitType::class)
        ;
        */
        // $form = $formBuilder->getForm();

        // Methode de récupération des données du formulaire
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){

            // deplace l'image où on veut la stocker
            //$product->getImage()->upload();

            // lien requete <-> formulaire - handlerequest
            // verif que les entrées sont correctes - isValid
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            // persisrt de l'Avis en dur dans le code -- à supprimer par la suite 
            $em->persist($avis1);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'produit bien enregistré.');

            // On redirige vers la page de visualisation du produit
            return $this->redirectToRoute('mickweb_ecommerce_fiche_produit', array('id' => $product->getId()));
        }


        // Si on n'est pas en post, on affiche le formulaire
        return $this->render('@MickwebEcommerce/Product/add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /*******************************MODIF PRODUIT****************************************************************/
    public function modifierAction($id, Request $request)
    {
        $product = $this->getDoctrine()
            ->getManager()
            ->getRepository('MickwebEcommerceBundle:Product')
            ->find($id)
        ;
        //$em = $this->getDoctrine()->getManager();

        // on récupère le produit $id
        //$product = $em->getRepository('MickwebEcommerceBundle:Product')->find($id);

        if (null === $product) {
            throw new NotFoundHttpException("Le produit d'id" .$id. "n'existe pas");
        }
/*
        $listCategories = $em->getRepository('MickwebEcommerceBundle:Category')->findAll();

        // boucle sur les categories pour lier au produit
        foreach ($listCategories as $category) {
            $product->addCategory($category);
        }
*/
        //$em->flush();

        /*********** */
        $form = $this->get('form.factory')->create(ProductModifierType::class, $product);
         // Methode de récupération des données du formulaire
         if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
             // lien requete <-> formulaire - handlerequest
             // verif que les entrées sont correctes - isValid
             $em = $this->getDoctrine()->getManager();
             $em->persist($product);
             $em->flush();

             $request->getSession()->getFlashBag()->add('notice', 'produit bien enregistré.');

             // On redirige vers la page de visualisation du produit
             return $this->redirectToRoute('mickweb_ecommerce_fiche_produit', array('id' => $product->getId()));
         }
         // Si on n'est pas en post, on affiche le formulaire
         return $this->render('@MickwebEcommerce/Product/modifier.html.twig', array(
             'product' => $product,
             'form' => $form->createView()
         ));
        /************ */
        /*$formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $product);

        $formBuilder
            ->add('titre',          TextType::class)
            ->add('description',    TextareaType::class)
            ->add('auteur',         TextType::class)
            ->add('published',      CheckboxType::class, array('required' => false))
            ->add('save',           SubmitType::class)
        ;

        $form = $formBuilder->getForm();

        // Methode de récupération des données du formulaire
        if($request->isMethod('POST')){
            // lien requete <-> formulaire
            $form->handleRequest($request);

            // verif que les entrées sont correctes
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($product);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'produit bien enregistré.');

                // On redirige vers la page de visualisation du produit
                return $this->redirectToRoute('mickweb_ecommerce_fiche_produit', array('id' => $product->getId()));
            }
        }

        // Si on n'est pas en post, on affiche le formulaire
        return $this->render('@MickwebEcommerce/Product/modifier.html.twig', array(
            'form' => $form->createView()
        ));
        */

    }

    /*******************************MODIFIER IMAGE****************************************************************/
    public function modifierImageAction($productId)
    {
        $em = $this->getDoctrine()->getManager();

        // On récupère l'annonce
        $product = $em->getRepository('MickwebEcommerceBundle:Product')->find($productId);

        // On modifie l'URL de l'image par exemple
        $product->getImage()->setUrl('https://images.unsplash.com/photo-1525923838299-2312b60f6d69');

        // On n'a pas besoin de persister l'annonce ni l'image.
        // ces entités sont automatiquement persistées car
        // on les a récupérées depuis Doctrine lui-même

        // On déclenche la modification
        $em->flush();

        return new Response('OK');
    }

    /*******************************SUPPRIMER PRODUIT****************************************************************/
    public function supprimerAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository('MickwebEcommerceBundle:Product')->find($id);

        if (null === $product) {
            throw new NotFoundHttpException("L'annonce d'id" .$id. "n'existe pas");
        }

        // formualire vide qui contient le champ CSRF
        // pour protéger la suppression de cette faille
        $form = $this->get('form.factory')->create();

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $em->remove($product);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', 'le produit a bien été supprimé.');

            return $this->redirectToRoute('mickweb_ecommerce_homepage');
        }

        return $this->render('@MickwebEcommerce/Product/supprimer.html.twig', array(
            'product' => $product,
            'form' => $form->createView()
        ));

    /*
        foreach($product->getCategories() as $category) {
            $product->removeCategory($category);
        }

        $em->flush();

        return $this->render('@MickwebEcommerce/Product/supprimer.html.twig', array('product' => $product
        ));
    */
    }

    /******************************* MENU ****************************************************************/
   
    /*
   
    public function menuAction($limit)
    {
        // On fixe en dur une liste ici, bien entendu par la suite
        // on la récupérera depuis la BDD !

    //    $listProducts = array(
    //    array('id' => 10, 'title' => 'T-shirt'),
    //    array('id' => 14, 'title' => 'Sweats'),
    //    array('id' => 9, 'title' => 'Casquettes')
    //    );

        $repository = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('MickwebEcommerceBundle:Product')
        ;

        $listProducts = $repository->myFindAll();
        return $this->render('MickwebEcommerceBundle:Product:menu.html.twig', array(

        // Tout l'intérêt est ici : le contrôleur passe
        // les variables nécessaires au template !

        'listProducts' => $listProducts
        ));

      
     // return $this->render('@MickwebEcommerce/Product/index.html.twig', array(
     //   'listProducts' => $listProducts
     //  ));
    
    }
    */
    
    /*******************************categories****************************************************************/
    public function categorieAction($categorie)
    {
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('MickwebEcommerceBundle:Product')->byCategorie($categorie);

        return $this->render('@MickwebEcommerce/Product/index.html.twig', array('produits' => $produits));
    }
}
