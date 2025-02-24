<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class BanWordValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        /* @var BanWord $constraint */

        if (null === $value || '' === $value) {
            return;
        }
        $value = Strtolower($value);
        foreach ($constraint->banWords as $banWord) {
            if (str_constrains($value, $banWord)) {
                //Chep doan code co san vo day
                 // TODO: implement the validation here
                $this->context->buildViolation($constraint->message)
                ->setParameter('{{ banWord }}', $banWord)
                ->addViolation()
            ;

            }
        }

       
      
    }
}
