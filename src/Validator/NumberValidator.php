<?php

namespace DLaravel\Validator;



use DLaravel\Validator;

/**
 *
 * 是否是数字
 */
class NumberValidator extends Validator
{

    public function validate(mixed $value, array $data): bool
    {
        return is_numeric($value);
    }

}
