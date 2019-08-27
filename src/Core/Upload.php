<?php

namespace Baaane\ImageOptimizer\Core;

use Baaane\ImageOptimizer\Exceptions\UploadHandlerException;

class Upload
{
    /**
     * File path
     *
     * @param string $filepath
     */
    public function __construct($filepath)
    {   
        if(isset($filepath) && (!empty($filepath)) ){
            if(!is_dir($filepath)){
                mkdir($filepath, 0775, true);
                chown($filepath, 'www-data');
                chmod($filepath, 0755 );
            }
            $path = $filepath;        
        }else{
            $defaultPath = dirname($_SERVER['DOCUMENT_ROOT']).'/uploads';
            if(!is_dir($defaultPath)){
                mkdir($defaultPath, 0775, true);
                chown($defaultPath, 'www-data');
                chmod($defaultPath, 0755 );
            }
            $path = $defaultPath;
        }

        $this->filepath = $path;
    }

    /**
     * Handle file
     *
     * @param array $data 
     * @return array
     */
    public function handle(array $data)
    {
    	$name = (isset($data['new_name']) && (!empty($data['new_name'])) ? $data['new_name'] : uniqid());
    	$ext = '.'.pathinfo($data['name'], PATHINFO_EXTENSION);

        if(empty($data) || !$this->check_file($data['tmp_name'])){
            throw new UploadHandlerException('No file exist!');
        }

        try{

            $this->upload($data['tmp_name'], $this->filepath.'/'.$name.$ext);
            $data_result = [
                'filename' => $name,
                'name' => $name.$ext,
                'type' => $data['type'],
                'tmp_name' => $data['tmp_name'],
                'path' => $this->filepath.'/',
                'filepath' => $this->filepath.'/'.$name.$ext
            ];
            
            return $data_result;
        
        } catch (UploadHandlerException $e) {
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


