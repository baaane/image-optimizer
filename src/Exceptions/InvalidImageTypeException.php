<?php

namespace Baaane\ImageOptimizer\Exceptions;

class InvalidImageTypeException extends \Exception
{
	public function __construct($message, $code = 500, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function checkMimeType($mime_type)
    {
    	return new static(sprintf("The image type %s is not supported!", $mime_type));
    }
}