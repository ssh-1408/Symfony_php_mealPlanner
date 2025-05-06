<?php

namespace App\Form;

use App\Entity\ShoppingList;
use App\Entity\ShoppingListItem;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShoppingListItemTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Shopping list name',
                'attr' => ['class' => 'form-control mb-3']
            ])

            ->add('amount', TextType::class, [
                'label' => 'Amount in g/ml/pieces',
                'attr' => ['class' => 'form-control mb-3']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ShoppingListItem::class,
        ]);
    }
}
