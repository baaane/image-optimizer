<?php

namespace Library\Baaane\ImageUploader\Exceptions;

class ImageUploaderException extends \Exception
{
    public function __construct($message, $code = 500, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function maxFileSize()
    {
        return new static("The uploaded file exceeds the upload_max_filesize in php.ini!");
    }

    public static function uploadMaxFilezize()
    {
        return new static("The uploaded file exceeds the MAX_FILE_SIZE!");
    }

    public static function noFileWasUploaded()
    {
        return new static("No file was uploaded!");
    }
}