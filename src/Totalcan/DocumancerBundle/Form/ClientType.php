<?php

namespace Totalcan\DocumancerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('variables')
            ->add('date')
            ->add('userId', 'entity', array('class'=>'Totalcan\DocumancerBundle\Entity\User', 'property'=>'variables', ));
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Totalcan\DocumancerBundle\Entity\Client'
        ));
    }

    public function getName()
    {
        return 'totalcan_documancerbundle_clienttype';
    }
}
