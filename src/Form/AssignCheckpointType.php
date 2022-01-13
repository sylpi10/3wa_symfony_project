<?php

namespace App\Form;

use App\Entity\Checkpoint;
use App\Entity\Producteur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssignCheckpointType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('producteur', EntityType::class, [
                'class' => Producteur::class,
                'choice_label' => function (?Producteur $producteur) {
                    return $producteur ? $producteur : '';
                },
                'multiple' => true,
                'expanded' => true,
                // 'choice_value' => function (?Producteur $producteur) {
                //     return $producteur ? $producteur->getId() : '';
                // },
            ])
            ->add('checkpoints', EntityType::class, [
                'class' => Checkpoint::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                // 'choice_value' => function (?Checkpoint $checkpoint) {
                //     return $checkpoint ? $checkpoint->getId() : '';
                // },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // 'data_class' => Producteur::class,
        ]);
    }
}
