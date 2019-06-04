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
    public function handle($data)
    {
    	$name = (isset($data['new_name']) ? $data['new_name'] : uniqid());
    	$ext = '.'.pathinfo($data['name'], PATHINFO_EXTENSION);

        if(empty($data) || !$this->check_file($data['tmp_name'])){
            throw new Exception('No file exists!');
        }

        try{
            $data_result = [
                'name' => $name.$ext,
                'type' => $data['type'],
                'tmp_name' => $data['tmp_name'],
                'error' =>$data['error'],
                'size'  =>$data['size'],
                'path' => $this->filePath
            ];
            
            return $data_result;
        
        } catch (Exception $e) {
            return $e;
        }
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

    public function file_type()
    {

    }
}


