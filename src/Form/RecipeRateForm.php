<?php

namespace App\Form;

use App\Entity\RecipeRating;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeRateForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('stars', ChoiceType::class, [
                'label' => 'Rate this recipe',
                'choices' => [
                    '⭐️ 1' => 1,
                    '⭐️⭐️ 2' => 2,
                    '⭐️⭐️⭐️ 3' => 3,
                    '⭐️⭐️⭐️⭐️ 4' => 4,
                    '⭐️⭐️⭐️⭐️⭐️ 5' => 5,
                ],

                'expanded' => true,
                'multiple' => false,
                'row_attr' => ['class' => 'rating-radio-group'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RecipeRating::class,
        ]);
    }
}
