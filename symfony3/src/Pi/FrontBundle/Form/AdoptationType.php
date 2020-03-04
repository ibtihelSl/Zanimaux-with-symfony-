<?php

namespace Pi\FrontBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdoptationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomprop')
            ->add('date')
            ->add('espece',ChoiceType::class
                ,array(
                    'choices'=>
                        array(
                            'Chien'=>'Chien',
                            'Chat'=>'Chat',
                            'Oiseaux'=>'Oiseaux',
                            'Cheval'=>'Cheval'
                        )))
            /*->add('animaux',EntityType::class,array(
                'class'=>'PiFrontBundle:Animaux',
                'choice_label'=>'nomA',
                'multiple'=>false,
            ))*/
            ->add('Ajouter',SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pi\FrontBundle\Entity\Adoptation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'pi_frontbundle_adoptation';
    }


}
