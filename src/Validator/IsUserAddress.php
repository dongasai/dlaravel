<?php

namespace DLaravel\Validator;

use App\Module\Ulogic\Model\UserAddress;
use DLaravel\Validator;

class IsUserAddress extends Validator
{

    /**
     * @param  mixed  $value
     * @param  array  $data
     * @return bool
     * 验证地址id是否属于该用户
     */
    public function validate(mixed $value, array $data): bool
    {
        $res = UserAddress::getUserAddress($data['userId'], $data['addressId']);
        if (!$res) {
            return false;
        }
        return true;
    }
}
