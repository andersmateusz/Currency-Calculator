<?php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use App\Entity\CurrencyManager;


class ValidKey extends Constraint
{
    public $message = 'Key not valid!';
    public $mode = 'strict'; // If the constraint has configuration options, define them as public properties

    public function validatedBy()
    {
     return static::class.'Validator';
    }
}
class ValidKeyValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ValidKey) {
            throw new UnexpectedTypeException($constraint, ValidKey::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) to take care of that
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            // throw this exception if your validator cannot handle the passed type so that it can be marked as invalid
            throw new UnexpectedValueException($value, 'string');

            // separate multiple types using pipes
            // throw new UnexpectedValueException($value, 'string|int');
        }

        // access your configuration options like this:
        if ('strict' === $constraint->mode) {
            // ...
        }
        $manager=new CurrencyManager($value); 
        $try['error']=null;
        $try=$manager->TryConnection();
        if (isset($try['error']))
        {
            $this->context->buildViolation($constraint->message)
            ->setParameter('{{ string }}', $value)
            ->addViolation();
        }
            
    }
}
?>