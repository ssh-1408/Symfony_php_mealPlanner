<?php

namespace App\Form;

use App\Entity\Bmi;
use App\Entity\User;
use App\Enum\Gender;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Enum\PhysicalActivityLevel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BmiForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mass', NumberType::class, [
                'label' => 'Weight (kg)',
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'Enter your weight in kg'
                ]
            ])
            ->add('height', NumberType::class, [
                'label' => 'Height (cm)',
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'Enter your height in cm'
                ]
            ])
            ->add('age', IntegerType::class, [
                'label' => 'Age',
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'Enter your age'
                ]
            ])
            ->add('gender', EnumType::class, [
                'class' => Gender::class,
                'label' => 'Gender',
                'choice_label' => fn(Gender $gender) => ucfirst($gender->value),
                'placeholder' => 'Select your gender',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('activityLevel', EnumType::class, [
                'class' => PhysicalActivityLevel::class,
                'choice_label' => fn($choice) => $choice->label(),
                'label' => 'Activity Level',
                'attr' => ['class' => 'form-control mb-3']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bmi::class,
        ]);
    }
}
