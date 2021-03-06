<?php

namespace Totalcan\DocumancerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Totalcan\DocumancerBundle\Form\RoleType;

class UserType extends AbstractType
{
    private $securityContext;

    public function __construct(SecurityContext $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('variables')
            ->add('email')
            ->add('password', 'password')
            ->add('rolesAsCollection', 'entity', array(
                'class' => 'TotalcanDocumancerBundle:Role',
                'property'     => 'name',
                'multiple'     => true
            ))
            ->add('companyId', 'entity', array(
                    'class'=>'Totalcan\DocumancerBundle\Entity\Company',
                    'property'=>'title',
                    'required' => false
            ))
            //->add('date')
        ;

        /*
         * $builder
            ->add('class')
            ->add('slug')
            ->add('next')
            ->add('prev')
            ->add('assetTitle')
            ->add('date', 'date', array(
                'widget' => 'choice',
                'pattern' => 'y',
                'years'         => range(date('Y') - 5, date('Y') + 5),
                'format'        => \IntlDateFormatter::MEDIUM,
                'label' => 'Разработано'))
            ->add('url', 'url', array(
                'label' => 'Ссылка'))
            ->add('title')
            ->add('description')
            ->add('carousel')
            ->add('tags', 'entity', array('class'=>'Knws\PortfolioBundle\Entity\Tag', 'property'=>'title', ));
         */
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Totalcan\DocumancerBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'totalcan_documancerbundle_usertype';
    }
}
