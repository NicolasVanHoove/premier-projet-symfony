<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\Brand;
use DateTimeImmutable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du modèle',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('price', IntegerType::class, [
                'label' => 'Prix de la voiture',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('release_date', DateType::class, [
                'label' => 'Date de sortie',
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                // 'data_class' => DateTimeImmutable::class,
                'required' => false,
                // 'mapped' => false,
                // 'empty_data' => "",
                'constraints' => [
                    new NotBlank(),
                    new NotNull(),
                ]
            ])
            ->add('poster', UrlType::class, [
                'label' => 'URL de l\'image de la voiture',
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 10
                    ]),
                ]
            ])
            ->add('brand', EntityType::class, [
                'class' => Brand::class,
                'choice_label' => 'name',
                'multiple' => false,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
