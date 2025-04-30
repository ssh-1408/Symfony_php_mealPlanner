<?php

namespace App\Form;

use App\Entity\Recipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextareaType::class)
            ->add('ingredients', TextareaType::class)
            ->add('preparationTime', IntegerType::class)
            ->add('calories', IntegerType::class)
            ->add('isVegetarian', CheckboxType::class, [
                'required' => false
            ])
            ->add('isVegan', CheckboxType::class, [
                'required' => false
            ])
            ->add('allergens', TextareaType::class)
            ->add('nutrients', TextareaType::class)
            ->add('externalLink', TextType::class, [
                'required' => false
            ])
            ->add('approvedByAdmin', CheckboxType::class, [
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
