<?php

namespace Library\ImageUploader;

use Exception;

class UploadController
{
    /**
     * File path
     *
     * @param string $filePath
     */
    public function __construct($filePath)
    {
    	$filePath = (isset($filePath) ? $filePath : storage_path('app/public/'));
        $this->filePath = rtrim($filePath);
    }

    /**
     * Handle file
     *
     * @param string $name
     * @return array $data
     */
    public function handle($name, $file = 'filename')
    {
    	$name = (isset($name) ? $name : uniqid());
    	$ext = '.'.pathinfo($_FILES[$file]['name'], PATHINFO_EXTENSION);

        if(empty($_FILES[$file]) || !$this->check_file($_FILES[$file]['tmp_name'])){
        	return FALSE;
        }

        $data = [
        	'name' => $name.$ext,
        	'type' => $_FILES[$file]['type'],
        	'tmp_name' =>  $_FILES[$file]['tmp_name'],
        	'error' => $_FILES[$file]['error'],
        	'size'	=> $_FILES[$file]['size'],
        	'path' => $this->filePath
        ];
        
        return $data;
        
    }

    /**
     * Check file if exist
     *
     * @param string $filename
     */
    public function check_file($filename)
    {
    	return file_exists($filename);
    }

    /**
     * Copy file if exist
     *
     * @param string $filename
     * @param string $destination
     *
     */
    public function upload($filename, $destination)
    {
    	return copy($filename, $destination);
    }
}


