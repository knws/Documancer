<?php

namespace Totalcan\DocumancerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;

class ClientType extends AbstractType
{
    private $securityContext;

    public function __construct(SecurityContext $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('variables', 'text', array(
                'label' => 'Переменные'))
            //->add('date')
            ->add('userId', 'entity', array('class'=>'Totalcan\DocumancerBundle\Entity\User', 'property'=>'username' ))
            ->add('exId')

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
