<?php

namespace Pi\adminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccessoiresType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prix')
            ->add('espece',ChoiceType::class
                ,array(
                    'choices'=>
                        array(
                            'Chien'=>'Chien',
                            'Chat'=>'Chat',
                            'Oiseaux'=>'Oiseaux',
                            'Cheval'=>'Cheval'
                        )))
            ->add("imageFile",FileType::class)
            ->add("Ajouter",SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pi\adminBundle\Entity\Accessoires'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'pi_adminbundle_accessoires';
    }


}
