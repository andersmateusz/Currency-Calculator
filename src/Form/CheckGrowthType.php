<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use App\Entity\CurrencyManager;


class CheckGrowthType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $manager= new CurrencyManager("1535a8ffed9a203d2b92a107a95d4ffa");
        $symbols=($manager->getSymbols())['symbols'];
        foreach($symbols as $key=>&$value)
        {
            $value=$key." (".$value.")";
        }
        $symbols=array_flip($symbols);
        $builder
            ->add('firstDate', DateType::class, array(
                'label' => false,
                'widget' => 'single_text',
                'input'=>'string',
            ))
            ->add('secondDate', DateType::class, [
                'label' => false,
                'widget'=>'single_text',
                'input'=>'string',
                
                

            ])
            ->add('first_currency', ChoiceType::class, [
                'choices'=> [
                    'Popular' =>[
                        'USD (United States Dollar)'=>'USD',
                        'EUR (Euro)'=>'EUR',
                        'PLN  (Polish Zloty)'=>'PLN',
                    ],
                        'ABC...'=>$symbols,
                ],
                'label'=>false,
                'placeholder'=>'Select Currency',

            ])
            ->add('second_currency', ChoiceType::class, [
                'choices'=> [
                    'Popular' =>[
                        'USD (United States Dollar)'=>'USD',
                        'EUR (Euro)'=>'EUR',
                        'PLN  (Polish Zloty)'=>'PLN',
                    ],
                        'ABC...'=>$symbols,
                ],
                 'label'=>false,
                 'placeholder'=>'Select Currency',
            ])
            ->add('submit', SubmitType::class, array('label' => false))
        ;
        

    }
}