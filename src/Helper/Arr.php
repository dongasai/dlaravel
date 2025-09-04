<?php

namespace DLaravel\Helper;

use Dcat\Admin\Grid\Filter\In;

/**
 * 数组判断工具
 *
 */
class Arr
{

    public function __construct(public array $data)
    {
    }


    /**
     * 判断数据是否 为null
     *
     * @param $index
     * @return bool
     */
    public function isNull($index)
    {
        $va = $this->data[$index] ?? null;

        return is_null($va);
    }

    /**
     * 判断数据是否为 number(数字或数字字符串)
     *
     * @param $index
     * @return bool
     */
    public function isNumber($index)
    {
        $va = $this->data[$index] ?? null;

        return is_numeric($va);
    }

    /**
     * 获取int 字符串
     *
     * @param $index
     * @return int
     */
    public function getNumber($index): int
    {
        $va = (integer)$this->data[$index] ?? 0;

        return (string)$va;
    }


    /**
     * 获取int数据
     *
     * @param $index
     * @return int
     */
    public function getInt($index): int
    {
        $va = (integer)$this->data[$index] ?? 0;

        return $va;
    }


}
