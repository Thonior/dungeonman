<?php

namespace Thonior\MasterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RateHeroType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('rating', 'rating', array('label' => 'Rating'));
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
        return 'thonior_masterbundle_rate_hero';
    }
}
