<?php

namespace Acts\CamdramSecurityBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class AceType
 *
 * The form that's presented when an Access Control Entry (ACE) is created
 */
class PendingAccessType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rid', 'hidden')
            ->add('type', 'hidden')
            ->add('email', 'email')
            ->add('send', 'submit')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acts\CamdramSecurityBundle\Entity\PendingAccess'
        ));
    }

    public function getName()
    {
        return 'acts_camdramsecuirtybundle_pendingaccesstype';
    }
}
