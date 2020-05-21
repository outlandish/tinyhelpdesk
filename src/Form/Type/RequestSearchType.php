<?php

namespace App\Form\Type;

use App\Entity\User;
use App\Form\DataClass\RequestSearchDataClass;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RequestSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $commonUserOptions = [
            'class' => User::class,
            'choice_label' => 'fullName',
            'placeholder' => 'Choose an option',
            'required' => false,
            'attr' => [
                'class' => 'custom-select d-block w-100',
            ],
        ];

        $builder
            ->add(
                'assignee',
                EntityType::class,
                array_merge($commonUserOptions, ['label' => 'Assigned To'])
            )
            ->add(
                'creator',
                EntityType::class,
                array_merge($commonUserOptions, ['label' => 'Creator'])
            )
            ->add('page', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RequestSearchDataClass::class,
            'csrf_protection' => false,
            'method' => 'GET',
        ]);
    }
}

