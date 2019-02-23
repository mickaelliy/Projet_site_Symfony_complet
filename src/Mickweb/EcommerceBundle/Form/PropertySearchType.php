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
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Mickweb\EcommerceBundle\Form\ImageType;
use Mickweb\EcommerceBundle\Form\CategoryType;
use Mickweb\EcommerceBundle\Form\TvaType;

class PropertySearchType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('minPrice',       IntegerType::class, array(
                'required' => false,
                'label' => false,
                'attr' => [ 'placeholder' => 'Prix minimum']
            ))
            ->add('maxPrice',       IntegerType::class, array(
                'required' => false,
                'label' => false,
                'attr' => [ 'placeholder' => 'Budget max']
            ))
            // ->add('submit',           SubmitType::class, array(
            //     'label' => 'lancer la recherche'
            // ))

        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mickweb\EcommerceBundle\Entity\PropertySearch',
            'method' => 'get',
            'csrf_protection' => false
        ));
    }

    // changer le prefixe utilisé
    public function getBlockPrefix()
    {
        return '';
    }

}
