<?php

namespace App\Util;

use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class ValidatorFormUtil
{
    public static function greaterThanZero(): GreaterThan
    {
        return new GreaterThan([
            'value' => 0,
            'message' => 'O número deve ser maior que 0.',
        ]);
    }

    public static function greaterOrEqualThanZero(): GreaterThanOrEqual
    {
        return new GreaterThanOrEqual([
            'value' => 0,
            'message' => 'O número deve ser maior ou igual a 0.',
        ]);
    }
}