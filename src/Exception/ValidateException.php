<?php


namespace DLaravel\Exception;

use Throwable;
use DLaravel\ValidationCore;

class ValidateException extends \Exception
{

    /**
     * @var ValidationCore $validation
     */
    public $validation;

    public function __construct($validation, $message = "", $code = 422, Throwable $previous = null)
    {
        $this->validation = $validation;

        parent::__construct($message, $code, $previous);
    }

}
