<?php

namespace CGG\ConferenceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array('constraints' => array(new NotBlank(array('message' => 'Ce champ es requis.')))))
            ->add('plainPassword', 'repeated', array('type' => 'password'))
            ->add('email', 'email', array('constraints' => array(new NotBlank(array('message' => 'Ce champ est requis.')))))
            ->add('envoyer', 'submit')
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
