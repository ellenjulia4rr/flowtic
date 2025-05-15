<?php

declare(strict_types=1);

namespace App\Form\Type\Filter;

use App\Filter\ServiceFilter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) :void
    {
        parent::buildForm($builder, $options);

        $builder->add('description', TextType::class, [
            'required' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ServiceFilter::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true,
        ]);
    }
}
