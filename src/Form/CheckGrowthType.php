<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;



class CheckGrowthType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstDate', DateType::class, array(
                'label' => false,
                'widget' => 'single_text'
            ))
            ->add('secondDate', DateType::class, [
                'label' => false,
                'widget'=>'single_text',
                
                

            ])
            ->add('first_currency', ChoiceType::class, [
                'choices'=>[
                    'USD'=>'USD',
                    'EUR'=>'USD',
                    'PLN'=>'PLN',
                ], 'label'=>false

            ])
            ->add('second_currency', ChoiceType::class, [
                'choices'=>[
                    'USD'=>'USD',
                    'EUR'=>'USD',
                    'PLN'=>'PLN',
                ], 'label'=>false
            ])
            ->add('submit', SubmitType::class, array('label' => false))
        ;
        

    }
}