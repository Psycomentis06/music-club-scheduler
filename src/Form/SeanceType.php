<?php

namespace App\Form;

use App\Entity\Activity;
use App\Entity\Coach;
use App\Entity\Seance;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('DateSe', DateTimeType::class, [
                    'date_label' => 'Starts On',
            ])
            ->add('heureDebut', DateTimeType::class, [
                'date_label' => 'Starts On',
        ])
            ->add('heureFin', DateTimeType::class, [
                'date_label' => 'Starts On',
        ])
            ->add('codaAct', EntityType::class, [
                'class' => Activity::class
             ])
            ->add('codeCo', EntityType::class, [
                'class' => Coach::class
             ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'fluid'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Seance::class,
        ]);
    }
}
