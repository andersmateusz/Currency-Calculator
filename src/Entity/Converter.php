<?php
namespace App\Entity;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Converter
{
    protected $firstCurrency;
    protected $secondCurrency;
    protected $value;

    public function getFirstCurrency(): string
    {
        return $this->firstCurrency;
    }

    public function setFirstCurrency( $firstCurrency): void
    {
        $this->firstCurrency = $firstCurrency;
    }

    public function getSecondCurrency(): string
    {
        return $this->secondCurrency;
    }

    public function setSecondCurrency( $secondCurrency): void
    {
        $this->secondCurrency = $secondCurrency;
    }
    public function getValue(): float
    {
        return $this->value;
    }

    public function setValue( $value):void
    {
        $this->value = $value;
    }
    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('firstCurrency', new NotBlank());

        $metadata->addPropertyConstraint('secondCurrency', new NotBlank());
        $metadata->addPropertyConstraint('value', new NotBlank());                    
        $metadata->addPropertyConstraint('firstCurrency', new Assert\Choice([
            'callback'=> 'getSymbols',
            'message'=> 'Choose a valid currency code.',
        ]));
        $metadata->addPropertyConstraint('secondCurrency', new Assert\Choice([
            'callback'=> 'getSymbols',
            'message'=> 'Choose a valid currency code.',
        ]));
    }
    public static function getSymbols()
    {
        $manager= new CurrencyManager($_POST['apiKey']);
        $symbols=($manager->getSymbols())['symbols'];
        foreach($symbols as $key=>&$value)
        {
            $value=$key." (".$value.")";
        }
        $symbols=array_flip($symbols);
        return array_values($symbols);
    }
 
    
}
?>