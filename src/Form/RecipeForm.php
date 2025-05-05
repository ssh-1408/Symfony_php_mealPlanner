<?php

namespace App\Form;

use App\Entity\Recipe;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class RecipeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Recipe Title',
                'attr' => ['class' => 'form-control mb-3']
            ])
            ->add('image', FileType::class, [
                'label' => 'Recipe Image',
                'mapped' => false,
                'required' => false,
                'attr' => ['class' => 'form-control mb-3'],
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => ['image/*'],
                        'mimeTypesMessage' => 'Please upload a valid image file.',
                    ])
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Short Description',
                'attr' => ['class' => 'form-control mb-3', 'rows' => 3]
            ])
            ->add('ingredients', TextareaType::class, [
                'label' => 'Ingredients (comma-separated)',
                'attr' => ['class' => 'form-control mb-3', 'rows' => 5]
            ])
            ->add('preparationTime', IntegerType::class, [
                'label' => 'Preparation Time (minutes)',
                'attr' => ['class' => 'form-control mb-3']
            ])
            ->add('calories', IntegerType::class, [
                'label' => 'Calories',
                'attr' => ['class' => 'form-control mb-3']
            ])
            ->add('isVegetarian', CheckboxType::class, [
                'label' => 'Vegetarian?',
                'required' => false
            ])
            ->add('isVegan', CheckboxType::class, [
                'label' => 'Vegan?',
                'required' => false
            ])
            ->add('allergens', TextType::class, [
                'label' => 'Allergens',
                'required' => false,
                'attr' => ['class' => 'form-control mb-3']
            ])
            ->add('nutrients', TextType::class, [
                'label' => 'Nutritional Information',
                'required' => false,
                'attr' => ['class' => 'form-control mb-3']
            ])
            ->add('externalLink', UrlType::class, [
                'label' => 'External Recipe Link',
                'required' => false,
                'attr' => ['class' => 'form-control mb-3']
            ])
            ->add('approvedByAdmin', CheckboxType::class, [
                'label' => 'Approved?',
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
