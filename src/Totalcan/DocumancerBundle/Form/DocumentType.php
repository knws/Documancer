<?php

namespace Totalcan\DocumancerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\SecurityContext;

class DocumentType extends AbstractType
{

    private $securityContext;

    public function __construct(SecurityContext $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('label' => 'Название документа') )
            ->add('variables', 'textarea', array('label' => 'Переменные') )
            ->add('template', 'textarea', array('label' => 'Шаблон'))
            ->add('date', null);

        if (true === $this->securityContext->isGranted('ROLE_ADMIN')) {
            $builder
                ->add('userId', 'entity', array(
                    'class'=>'Totalcan\DocumancerBundle\Entity\User',
                    'property'=>'id'
                    ))
                ->add('designId', 'entity', array(
                    'class'=>'Totalcan\DocumancerBundle\Entity\Design',
                    'property'=>'id'
                    ))
                ->add('templateId', 'entity', array(
                    'class'=>'Totalcan\DocumancerBundle\Entity\Template',
                    'property'=>'id'
                    ))
                ->add('clientId', 'entity', array(
                    'class'=>'Totalcan\DocumancerBundle\Entity\Client',
                    'property'=>'id'
                    ))
            ;
        } else {
            $usr = $this->securityContext->getToken()->getUser();
            $builder
                ->add('designId', 'entity', array(
                    'class'=>'Totalcan\DocumancerBundle\Entity\Design',
                    'property'=>'id',
                    'query_builder' => function(EntityRepository $er) {
                            return $er->createQueryBuilder('d')
                                    ->where('d.userId > :userId')
                                    ->setParameter('userId', $usr->getId())
                                    ->orderBy('d.id', 'ASC');
                        }
                    ))
                ->add('templateId', 'entity', array(
                    'class'=>'Totalcan\DocumancerBundle\Entity\Template',
                    'property'=>'id',
                    'query_builder' => function(EntityRepository $er) {
                            return $er->createQueryBuilder('d')
                                    ->where('d.userId > :userId')
                                    ->setParameter('userId', $usr->getId())
                                    ->orderBy('d.id', 'ASC');
                        }
                    ))
                ->add('clientId', 'entity', array(
                    'class'=>'Totalcan\DocumancerBundle\Entity\Client',
                    'property'=>'id',
                    'query_builder' => function(EntityRepository $er) {
                            return $er->createQueryBuilder('d')
                                    ->where('d.userId > :userId')
                                    ->setParameter('userId', $usr->getId())
                                    ->orderBy('d.id', 'ASC');
                        }
                    ))
            ;
        }


    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Totalcan\DocumancerBundle\Entity\Document'
        ));
    }

    public function getName()
    {
        return 'totalcan_documancerbundle_documenttype';
    }
}
