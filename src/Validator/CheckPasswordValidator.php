<?php

namespace DLaravel\Validator;

use App\Module\User\Services\UserService;
use DLaravel\Validator;

class CheckPasswordValidator extends Validator
{

    /**
     * @param  mixed  $value
     * @param  array  $data
     * @return bool
     * 验证交易密码
     */
    public function validate(mixed $value, array $data): bool
    {
        // 判断是否绑定谷歌
        $isGoogle = UserService::isBindGoogle($data['userId']);
        if ($isGoogle) {
            return true;
        } else {
            $check = UserService::checkSecretPassword($data['userId'], $data['password']);
            if (!$check) {
                return false;
            }
            return true;
        }
    }
}
