<?php

namespace AppBundle\Form;

use AppBundle\Entity\Url;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\UrlType as FormUrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UrlType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'url',
                FormUrlType::class,
                [
                    'label' => 'Url to shorten',
                    'attr'=> [
                        'class' => 'form-control large',
                        'maxlength' => 255,
                    ],
                ]
            )
            ->add(
                'shorten',
                SubmitType::class,
                [
                    'label' => 'Short it!',
                ]
            );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Url::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_url';
    }
}
