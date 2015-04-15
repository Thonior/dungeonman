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
        
        $universe = $options['data']->getUniverse()->getId();
        $builder
            ->add('name')
            ->add('file')
            ->add('alignment')
            ->add('race','entity', array(
                'class' => 'Thonior\MasterBundle\Entity\Race',
                'query_builder' => function ($er) use ($universe) {
                    return $er->createQueryBuilder('r')
                            ->where('r.universe = :id')
                            ->setParameter('id',$universe);
                }
            ))
            ->add('classes','entity', array(
                'class' => 'Thonior\MasterBundle\Entity\Job',
                'query_builder' => function ($er) use ($universe) {
                    return $er->createQueryBuilder('r')
                            ->where('r.universe = :id')
                            ->setParameter('id',$universe);
                }
            ))
            ->add('level')
            ->add('description')
            ->add('script')
            ->add('health')
            ->add('tags', 'text',array('required' => false));
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
