<?php

namespace Thonior\MasterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArmorType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('shopPrice')
            ->add('sellPrice')
            ->add('weight')
            ->add('CA')
            ->add('penalty')
            ->add('position')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Thonior\MasterBundle\Entity\Armor'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'thonior_masterbundle_armor';
    }
}
