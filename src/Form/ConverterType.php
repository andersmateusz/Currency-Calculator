<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;


class ConverterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       
        $builder
        ->add('value', MoneyType::class, [
            'label' =>false,
            'currency'=>false,
            'divisor'=>100,
        ])
        ->add('first_currency', ChoiceType::class, [
            'choices'=>[
                'USD'=>'USD',
                'EUR'=>'USD',
                'PLN'=>'PLN',
            ], 'label'=>false
        ])
        ->add('second_currency', ChoiceType::class,[
            'choices'=>[
                'USD'=>'USD',
                'EUR'=>'USD',
                'PLN'=>'PLN',
            ], 'label'=>false
        ])
        ->add('submit', SubmitType::class, ['label'=>false])
    ;

    }
}