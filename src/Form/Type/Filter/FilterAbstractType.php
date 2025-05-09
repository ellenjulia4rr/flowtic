<?php

namespace App\Form\Type\Filter;

use App\Constants\PaginationLimitsTypes;
use App\Filter\AbstractFilter;
use App\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterAbstractType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'ACTIVE' => 'ACTIVE',
                    'INACTIVE' => 'INACTIVE'
                ],
                'required' => false,
            ])
            ->add('query', TextType::class, [
                'required' => false,
            ])
            ->add('perPage', ChoiceType::class, [
                'choices' => PaginationLimitsTypes::Limits
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AbstractFilter::class,
            'allow_extra_fields' => true,
            'method' => 'GET',
        ]);
    }
}
