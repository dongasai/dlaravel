<?php

namespace DLaravel\Validation;


use Illuminate\Database\Eloquent\Model;
use DLaravel\ValidationCore;

class ModelValidation extends ValidationCore
{

    /**
     * 使用模型数据 进行初始化
     *
     * @return static
     */
    public static function makeByModel(Model $model, $rules = [], $scene = '')
    {
        return new static($model->toArray(), $rules, [], $scene);
    }


}
