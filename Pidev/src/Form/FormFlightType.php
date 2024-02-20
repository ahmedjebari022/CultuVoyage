<?php

namespace App\Form;

use App\Entity\Flight;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormFlightType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('flightnum')
            ->add('departure_date')
            ->add('arrival_date')
            ->add('departure_hour')
            ->add('arrival_hour')
            ->add('destination')
            ->add('remaining_place')
            ->add('price')
            ->add('departure_city')
            ->add('arrival_city')
            ->add('plane')
            ->add('submite',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Flight::class,
        ]);
    }
}
