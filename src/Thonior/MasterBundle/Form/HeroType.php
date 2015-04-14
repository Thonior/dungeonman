<?php

namespace Thonior\MasterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HeroType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('alignment')
            ->add('level')
            ->add('description')
            ->add('media')
            ->add('script')
            ->add('health')
            ->add('tags', 'text');
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Thonior\MasterBundle\Entity\Hero'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'thonior_masterbundle_hero';
    }
}
