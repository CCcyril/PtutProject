<?php

namespace CGG\ConferenceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', 'textarea')
        ;

        $builder->add('content', 'ckeditor', array(
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
                    ),array(
                        'name'  => 'styles',
                        'items' => array('Styles', 'Format', 'Font', 'FontSize'),
                    ),array(
                        'name'  => 'colors',
                        'items' => array('TextColor', 'BGColor'),
                    ),array(
                        'name'  => 'paragraph',
                        'groups' => array('list', 'indent', 'blocks', 'align', 'bidi'),
                        'items' => array('NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language'),
                    ),array(
                        'name'  => 'links',
                        'items' => array('Link', 'Unlink', 'Anchor'),
                    ),array(
                        'name'  => 'insert',
                        'items' => array('Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe'),
                    ),
                ),
                'uiColor' => '#cecece',
                //...
            ),
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        /*$resolver->setDefaults(array(
            'data_class' => 'CGG\ConferenceBundle\Entity\Conference'
        ));*/
    }

    public function getName()
    {
        return 'cgg_conferencebundle_content';
    }
}
