<?php

namespace Library\Baaane\ImageUploader\Core;

use Exception;

class Upload
{
    /**
     * File path
     *
     * @param string $filePath
     */
    public function __construct($filePath)
    {   
        if(isset($filePath)){
            if(!is_dir($filePath)){
                mkdir($filePath, 0775, true);
                chown($filePath, 'www-data');
                chmod($filePath, 0755 );
            }
            $path = $filePath;        
        }else{
            $defaultPath = dirname($_SERVER['DOCUMENT_ROOT']).'/storage/app/public/';
            if(!is_dir($defaultPath)){
                mkdir($defaultPath, 0775, true);
                chown($defaultPath, 'www-data');
                chmod($defaultPath, 0755 );
            }
            $path = $defaultPath;
        }

        $this->filePath = $path;
    }

    /**
     * Handle file
     *
     * @param array $data 
     * @return array
     */
    public function handle(array $data)
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
}


