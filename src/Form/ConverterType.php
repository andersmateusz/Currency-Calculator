<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use App\Entity\CurrencyManager;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Converter;
use Symfony\Component\Validator\Constraints\NotBlank;

class ConverterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $manager= new CurrencyManager($_POST['apiKey']);
        $symbols=($manager->getSymbols())['symbols'];
        foreach($symbols as $key=>&$value)
        {
            $value=$key." (".$value.")";
        }
        $symbols=array_flip($symbols);
        $builder
        ->add('value', MoneyType::class, [
            'label' =>false,
            'currency'=>false,
           
            
        ])
        ->add('firstCurrency', ChoiceType::class, [
            'choices'=> [
                'Popular' =>[
                    'USD (United States Dollar)'=>'USD',
                    'EUR (Euro)'=>'EUR',
                    'PLN  (Polish Zloty)'=>'PLN',
                    'Test Validation'=> 'TestingValidation',
                     ], 
                     'ABC'=>$symbols,
                ],
            'label'=>false,
            'placeholder'=>'Select Currency',
        ])
        ->add('secondCurrency', ChoiceType::class,[
            'choices'=> [
                'Popular' =>[
                    'USD (United States Dollar)'=>'USD',
                    'EUR (Euro)'=>'EUR',
                    'PLN  (Polish Zloty)'=>'PLN',
                    'Test Validation'=> 'TestingValidation',
                ], 'ABC'=>$symbols,
                    
            ],
            'label'=>false,
            'placeholder'=>'Select Currency',
        ])
        ->add('submit', SubmitType::class, ['label'=>false])
    ;

    }
   
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Converter::class,
        ]);
    }
    
    
}