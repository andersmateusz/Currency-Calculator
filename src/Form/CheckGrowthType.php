<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use App\Entity\CurrencyManager;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Checker;


class CheckGrowthType extends AbstractType
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
            ->add('startDate', DateType::class, array(
                'label' => false,
                'widget' => 'single_text',
                'input'=>'string',
            ))
            ->add('endDate', DateType::class, [
                'label' => false,
                'widget'=>'single_text',
                'input'=>'string',
                
                

            ])
            ->add('firstCurrency', ChoiceType::class, [
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
            ->add('secondCurrency', ChoiceType::class, [
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
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Checker::class,
        ]);
    }
}