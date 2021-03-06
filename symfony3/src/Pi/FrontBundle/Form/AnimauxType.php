<?php

namespace Pi\FrontBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimauxType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomA')

            ->add('age')
            ->add('poids')
            ->add('race')
            ->add('espece',ChoiceType::class
                ,array(
                    'choices'=>
                        array(
                            'Chien'=>'Chien',
                            'Chat'=>'Chat',
                            'Oiseaux'=>'Oiseaux',
                            'Cheval'=>'Cheval'
                        )))
            ->add('file')

        ->add('Ajouter',SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pi\FrontBundle\Entity\Animaux'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'pi_frontbundle_animaux';
    }


}
