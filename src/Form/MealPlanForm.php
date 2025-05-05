<?php

namespace App\Form;

use App\Entity\MealPlan;
use App\Entity\Recipe;
use App\Entity\User;
use App\Enum\Mealtime;
use App\Repository\RecipeRepository;
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
        $filter = $options['filter'];

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
                'choice_label' => 'title',
                'label' => 'Choose a Recipe',
                'attr' => ['class' => 'form-select mb-3'],
                'query_builder' => function (RecipeRepository $repo) use ($filter) {
                    $qb = $repo->createQueryBuilder('r');

                    if ($filter === 'vegan') {
                        $qb->where('r.isVegan = true');
                    } elseif ($filter === 'vegetarian') {
                        $qb->where('r.isVegetarian = true');
                    } elseif ($filter === 'low_calories') {
                        $qb->where('r.calories < 200');
                    } elseif ($filter === 'quick') {
                        $qb->where('r.preparationTime < 30');
                    }

                    return $qb->orderBy('r.title', 'ASC');
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MealPlan::class,
            'filter' => null,

        ]);
    }
}
