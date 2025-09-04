<?php

namespace DLaravel\Helper;


class Api
{






    /**
     * API,错误返回
     * @param $message
     * @param $code
     * @param $data
     * @return false|string
     */
    static public function error($message = '错误',$code = 400,$data =[])
    {
        return static::return_json($code,$message,$data,false);
    }

    /**
     * 成功的返回
     * @param $data
     * @param $message
     * @param $code
     * @return false|string
     */
    static public function successData($data,$message = '成功',$code = 200)
    {
        return self::return_json($code,$message,$data,true);
    }

    /**
     * 进行res 数据判定返回
     *
     * @param $data
     * @param $message
     * @param $code
     * @return false|string
     */
    static public function resData($data,$message = '成功',$code = 200)
    {
        if(is_string($data)){
            return self::error($data);
        }
        return self::return_json($code,$message,$data,true);
    }

    /**
     * 返回验证错误
     *
     * @param ValidationCore $validationCore
     * @return void
     */
    static public function returnValidation(ValidationCore $validationCore,$msg = null)
    {
        $msg =$msg?? $validationCore->firstError();
       return  self::return_json(422,$msg,$validationCore->getSourceData(),false);
    }


    /**
     * 处理Laravel的验证错误
     * @param \Illuminate\Validation\ValidationException $validationException
     * @return false|string
     */
    static public function returnValidationException(\Illuminate\Validation\ValidationException $validationException)
    {
        return  self::return_json(422,$validationException->getMessage(),$validationException->validator->getData(),false);
    }

    /**
     * 组织API返回json串
     * @param $code
     * @param $msg
     * @param $data
     * @return false|string
     */
    static public function return_json($code = 200, $msg = '', $data = [],$success = true)
    {
        $json =  json_encode([
                               "success"=>$success,
                               'code' => $code,
                               'message'  => $msg,
                               'data' => $data,
                               'unid' => RUN_UNIQID
                           ]);
        return   response($json);

    }

    /**
     * 多判断返回
     * @param $data
     * @param $msg
     * @return false|string|null
     */
    static public function returnRes($data ,$msg = [])
    {
        if(is_string($data)){
            return self::error($data,$msg);
        }
        if($data instanceof  ValidationCore ){
            return self::returnValidation($data);
        }
        return self::successData($data,$data);
    }

}
