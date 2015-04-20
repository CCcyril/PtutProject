<?php

namespace CGG\ConferenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lname')
            ->add('fname')
            ->add('email')
            ->add('address')
            ->add('country')
            ->add('zipcode')
            ->add('status')
            ->add('phone')
            ->add('inscriptionDate')
            ->add('send', 'submit')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CGG\ConferenceBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'cgg_conferencebundle_user';
    }
}
