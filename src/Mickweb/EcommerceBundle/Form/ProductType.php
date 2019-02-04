<?php

namespace Mickweb\EcommerceBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Mickweb\EcommerceBundle\Form\ImageType;
use Mickweb\EcommerceBundle\Form\CategoryType;
use Mickweb\EcommerceBundle\Form\TvaType;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',          TextType::class)
            ->add('description',    TextareaType::class)
            ->add('auteur',         TextType::class)
            ->add('published',      CheckboxType::class, array('required' => false))
            ->add('image',          ImageType::class)
            // Le add ci-dessous sert à ajouter une catégorie
            
            // ->add('categories',     CollectionType::class, array(
            //    'entry_type' => CategoryType::class,
            //    'allow_add' => true,
            //    'allow_delete' => true
            // ))
            
            // le add ci-dessous ne fonctionne pas comme je souhaite, il n'ajoute pas la catégorie, a corriger
            ->add('categories',     EntityType::class, array(
                'class'         => 'MickwebEcommerceBundle:Category',
                'choice_label'  => 'name',
                'multiple'      => false,
                'expanded'      => false,
                'mapped'        => true, 
            ))
            // ->add('tva',            EntityType::class, array(
            //     'class'         => 'MickwebEcommerceBundle:tva',
            //     'choice_label'  => 'name',
            //     'multiple'      => false,
            //     'expanded'      => false,
            //     'mapped'        => true, 
            // ))
            ->add('prix',           MoneyType::class)
            ->add('save',           SubmitType::class)
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mickweb\EcommerceBundle\Entity\Product'
        ));
    }

}
