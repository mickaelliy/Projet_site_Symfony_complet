<?php

namespace Mickweb\EcommerceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProductModifierType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // A mettre si je veux cacher un champs
        /*  
        $builder
            ->remove('titre');
        */
    }
    
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
       return ProductType::class;
    }
}
