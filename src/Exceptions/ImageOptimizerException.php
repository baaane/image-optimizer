<?php

namespace Baaane\ImageOptimizer\Exceptions;

class ImageOptimizerException extends \Exception
{
    public function __construct($type)
    {
        $phpFileUploadErrors = array(
            0 => 'There is no error, the file uploaded with success!',
            1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini!',
            2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form!',
            3 => 'The uploaded file was only partially uploaded!',
            4 => 'No file was uploaded!',
            6 => 'Missing a temporary folder!',
            7 => 'Failed to write file to disk!',
            8 => 'A PHP extension stopped the file upload!',
        );

        $message = $phpFileUploadErrors[$type];
        
        if(!array_key_exists($type, $phpFileUploadErrors)){
            $message = 'Undefined Error!';
        }

        parent::__construct($message);
    }

    public static function noErrorKey()
    {
        return new static("Required error key!");
    }
}