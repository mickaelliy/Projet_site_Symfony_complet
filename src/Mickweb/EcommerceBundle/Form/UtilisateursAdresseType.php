<?php

namespace Mickweb\EcommerceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class UtilisateursAdresseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',        TextType::class)
            ->add('prenom',     TextType::class)
            ->add('telephone',  NumberType::class)
            ->add('adresse',    TextType::class)
            ->add('cp',         NumberType::class)
            ->add('pays',       TextType::class)
            ->add('ville',      TextType::class)
            ->add('complement', null, array('required' => false))
            //->add('user')
            ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mickweb\EcommerceBundle\Entity\UtilisateursAdresse'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mickweb_ecommercebundle_utilisateursadresse';
    }


}
