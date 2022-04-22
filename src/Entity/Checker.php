<?php
namespace App\Entity;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class Checker
{
    protected $firstCurrency;
    protected $secondCurrency;
    protected $startDate;
    protected $endDate;

    public function getFirstCurrency(): string
    {
        return $this->firstCurrency;
    }



    public function setFirstCurrency(string $firstCurrency): void
    {
        $this->firstCurrency = $firstCurrency;
    }

    public function getSecondCurrency(): string
    {
        return $this->secondCurrency;
    }

    public function setSecondCurrency(string $secondCurrency): void
    {
        $this->secondCurrency = $secondCurrency;
    }
    public function getStartDate(): string
    {
        return $this->startDate;
    }

    public function setStartDate(string $startDate):void
    {
        $this->startDate = $startDate;
    }
    public function getEndDate(): string
    {
        return $this->endDate;
    }

    public function setEndDate(string $endDate):void
    {
        $this->endDate = $endDate;
    }
    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('firstCurrency', new NotBlank());

        $metadata->addPropertyConstraint('secondCurrency', new NotBlank());
        $metadata->addPropertyConstraint('startDate', new NotBlank());
        $metadata->addPropertyConstraint('endDate', new NotBlank());                    
    
    }
}
?>