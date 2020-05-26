<?php

namespace App\Form\Type;

use App\Entity\Request;
use App\Entity\RequestPriority;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                TextType::class
            )
            ->add(
                'text',
                TextareaType::class
            )
            ->add(
                'priority',
                EntityType::class,
                [
                    'class' => RequestPriority::class,
                    'choice_label' => 'name',
                    'placeholder' => 'Choose an priority',
                    'attr' => [
                        'class' => 'custom-select d-block w-100',
                    ],
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Request::class]);
    }
}

