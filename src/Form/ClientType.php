<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) :void
    {
        $builder
            ->add('fullName', TextType::class, [
                'required' => true,
            ])
            ->add('email', EmailType::class, [
                'required' => false,
                'mapped' => false,
            ])
            ->add('phone', TextType::class, [
                'required' => true,
            ])
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
                $inputEmail = $event->getForm()->get('email')->getData();
                if ($inputEmail) {
                    /** @var Client $client */
                    $client = $event->getData();
                    $client->getUser()->setEmail($inputEmail);
                }
            })
        ;

    }

    public function configureOptions(OptionsResolver $resolver) :void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true,
        ]);
    }
}
