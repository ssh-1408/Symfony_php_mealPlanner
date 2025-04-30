<?php

namespace App\Form;

use App\Entity\MealPlan;
use App\Entity\Recipe;
use App\Entity\User;
use App\Enum\Mealtime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MealPlanForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mealDate', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'Select a date',
                ],
                'label' => 'Meal Date',
            ])
            ->add('mealtime', EnumType::class, [
                'class' => Mealtime::class,
                'attr' => [
                    'class' => 'form-select mb-3',
                ],
                'label' => 'Meal Time',
            ])
            ->add('recipe', EntityType::class, [
                'class' => Recipe::class,
                'choice_label' => 'title', // Better than 'id' for users
                'attr' => [
                    'class' => 'form-select mb-3',
                ],
                'label' => 'Choose a Recipe',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MealPlan::class,
        ]);
    }
}
