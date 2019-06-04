<?php

namespace Library\ImageUploader;

use Exception;
use Library\ImageUploader\UploadController;
use Library\ImageUploader\ImageActionInterface;
use Library\ImageUploader\ThumbnailImageController;
use Library\ImageUploader\MobileImageController;
use Library\ImageUploader\DesktopImageController;

class ImageUpload
{
    /**
     * File path
     *
     * @param string $filePath
     */
    public function __construct($filePath = NULL)
    {
        $this->filePath = $filePath;
    }

	/**
	 * Execute of specific function
	 * @param Library\ImageUploader\ImageActionInterface $exec
	 */
	public function action(ImageActionInterface $exec)
	{		
		return $exec->action();
	}

	/**
	 * Upload the image
	 * @param string $name
	 *
	 */
	public function upload($data, $name = [])
	{	
		if(!empty($name) || !(isset($name))){
			$name = ['new_name' => $name];
			$data = array_merge($data, $name);
		}

		$data_array = $this->reArrayFiles($data);

		if(count($data_array) === 0){
			throw new Exception('No data exists!');
		}

		$upload = new UploadController($this->filePath);
		for ($i=0; $i < count($data_array); $i++) {
			if($data_array[$i]['error'] == 0){
				$data_result = $upload->handle($data_array[$i]);
				$result[] = $this->resize($data_result);
			}
		}
		
		return $result;
	}

	/**
	 * Resizing the image
	 * Thumbnail|Mobile|Desktop	
	 *
	 * @param array $data
	 * @return array $data
	 *
	 */
	public function resize($data)
	{
		//thumbnail
		$thumbnailController = new ThumbnailImageController($data);
		$thumbnail = $thumbnailController->action();
		
		//mobile
		$mobileController = new MobileImageController($data);
		$mobile = $mobileController->action();

		//desktop
		$desktopController = new DesktopImageController($data);
		$desktop = $desktopController->action();

		$data = [
			'thumbnail' => $thumbnail,
			'mobile'	=> $mobile,
			'deskctop'	=> $desktop
		];

		return $data;
	}

	/**
	 * Re-arrange the array	
	 *
	 * @param array $data
	 * @return array $data
	 *
	 */

	public function reArrayFiles(&$data_array) {

    	$data = [];
	    $file_count = count($data_array['name']);
	    $file_keys = array_keys($data_array);

	    for ($i=0; $i<$file_count; $i++) {
	        foreach ($file_keys as $key => $value) {
	            $data[$i][$value] = $data_array[$value][$i];
	        }
	    }
	    return $data;
	}
}