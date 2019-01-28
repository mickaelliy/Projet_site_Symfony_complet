<?php

namespace Mickweb\EcommerceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Mickweb\EcommerceBundle\Form\ImageType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;


class TvaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('multiplicate',   MoneyType::class, ['divisor' => 100])
            ->add('nom',            TextType::class)
            ->add('valeur',         MoneyType::class, ['divisor' => 100])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mickweb\EcommerceBundle\Entity\tva'
        ));
    }

}
