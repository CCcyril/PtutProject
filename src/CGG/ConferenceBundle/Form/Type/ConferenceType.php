<?php

namespace CGG\ConferenceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class ConferenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('constraints' => array(new NotBlank(array('message' => 'Veuillez nommer la conférence.')))))
            ->add('startDate', 'date', array('widget' => 'single_text', 'format'=> 'dd/MM/yyyy', 'constraints' => array(new NotBlank(array('message' => 'La date de début est requise.')))))
            ->add('endDate', 'date', array('widget' => 'single_text', 'format'=> 'dd/MM/yyyy', 'constraints' => array(new NotBlank(array('message' => 'La date de fin est requise.')))))
            ->add('description', 'textarea')
            ->add('valider', 'submit')
        ;

        /* new NotBlank(array('message' => 'Ce champ est requis.')) */

        $builder->add('description', 'ckeditor', array(
            'config' => array(
                'toolbar' => array(
                    array(
                        'name'  => 'document',
                        'items' => array('Source', '-', 'Save', 'NewPage', 'DocProps', 'Preview', 'Print', '-', 'Templates'),
                    ),
                    '/',
                    array(
                        'name'  => 'basicstyles',
                        'items' => array('Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'),
                    ),
                ),
                'uiColor' => '#cecece',
                //...
            ),
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CGG\ConferenceBundle\Entity\Conference'
        ));
    }

    public function getName()
    {
        return 'cgg_conferencebundle_conference';
    }
}
