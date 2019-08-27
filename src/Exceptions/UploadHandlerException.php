<?php

namespace Baaane\ImageOptimizer\Exceptions;

class UploadHandlerException extends \Exception
{
	public function __construct($message, $code = 500, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}