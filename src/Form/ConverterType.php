<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ConverterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstDate', DateType::class)
            ->add('secondDate', DateType::class)
            ->add('first_currency', ChoiceType::class)
            ->add('second_currency', ChoiceType::class)
            ->add('submit', SubmitType::class)
        ;
        ;

    }
}