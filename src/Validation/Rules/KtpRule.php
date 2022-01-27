<?php

declare(strict_types=1);

namespace App\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;
use Respect\Validation\Validator as v;

class KtpRule extends AbstractRule
{
    private string $dateOfBirth;
    private string $sex;

    public function __construct($dateOfBirth, $sex)
    {
        $this->dateOfBirth = $dateOfBirth;
        $this->sex = $sex;
    }

    public function validate($input): bool
    {
        $input = (string) $input;
        $number = v::number()->notEmpty()->length(16, 16)->validate($input);

        //Check Condition for Format KTP XXXXXXDDMMYYXXXX
        $subKtp = substr($input, 6, 6);

        $dateCreate = date_create($this->dateOfBirth);
        $dateFormat = date_format($dateCreate, "dmy");

        if ($number && $this->sex == 'M' && $dateFormat == $subKtp) {
            return true;
        } elseif ($number && $this->sex == 'F' && ($dateFormat + 400000) == $subKtp) {
            return true;
        }

        return false;
    }
}
