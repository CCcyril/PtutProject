<?php
/**
 * Created by PhpStorm.
 * User: user01
 * Date: 03/04/15
 * Time: 02:30
 */

namespace CGG\ConferenceBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ImageCompetitionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', 'textarea')
            ->add('file', 'file')
            ->add('title', 'text')
            ->add('envoyer', 'submit')
        ;
    }

    public function getName()
    {
        // TODO: Implement getName() method.
    }
}