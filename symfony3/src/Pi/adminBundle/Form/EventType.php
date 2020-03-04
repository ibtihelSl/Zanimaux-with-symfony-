<?php

namespace Pi\adminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('adresse')
            ->add('dateDebut')
            ->add('dateFin')
            ->add('type',ChoiceType::class
                ,array(
                    'choices'=>
                        array(
                            'payant'=>'payant',

                            'gratuit'=>'gratuit'
                        )
                ))
            ->add('nombrePlace')
            ->add('nombreReserve')
            ->add('details')
            ->add('save',SubmitType::class);;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pi\adminBundle\Entity\Event'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'pi_adminbundle_event';
    }


}
