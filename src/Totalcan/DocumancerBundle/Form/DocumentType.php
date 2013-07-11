<?php

namespace Totalcan\DocumancerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('label' => 'Название документа') )
            ->add('variables', 'textarea', array('label' => 'Переменные') )
            ->add('template', 'textarea', array('label' => 'Шаблон'))
            ->add('date', null)
            ->add('userId', 'entity', array('class'=>'Totalcan\DocumancerBundle\Entity\User', 'property'=>'id' ))
            ->add('designId', 'entity', array('class'=>'Totalcan\DocumancerBundle\Entity\Design', 'property'=>'id' ))
            ->add('templateId', 'entity', array('class'=>'Totalcan\DocumancerBundle\Entity\Template', 'property'=>'id' ))
            ->add('clientId', 'entity', array('class'=>'Totalcan\DocumancerBundle\Entity\Client', 'property'=>'id' ))
        ;
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
