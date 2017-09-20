<?php

namespace Acts\CamdramBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class VenueType
 *
 * The form that's presented when a user adds/edits a venue
 */
class VenueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('short_name')
            ->add('image', 'image_upload', array('label' => 'Photo'))
            ->add('college')
            ->add('description')
            ->add('address')
            ->add('location', 'map_location')
            ->add('facebook_id', 'facebook_link', array('required' => false))
            ->add('twitter_id', 'twitter_link', array('required' => false))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acts\CamdramBundle\Entity\Venue'
        ));
    }

    public function getName()
    {
        return 'venue';
    }
}
