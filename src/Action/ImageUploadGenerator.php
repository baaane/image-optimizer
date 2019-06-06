<?php

namespace Library\Baaane\ImageUploader\Action;

use Exception;
use Library\Baaane\ImageUploader\Core\Upload;
use Library\Baaane\ImageUploader\Contracts\ImageActionInterface;
use Library\Baaane\ImageUploader\Action\ThumbnailImageSize;
use Library\Baaane\ImageUploader\Action\MobileImageSize;
use Library\Baaane\ImageUploader\Action\DesktopImageSize;

class ImageUploadGenerator
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
	 *
	 * @param array $data
	 * @return array
	 *
	 */
	public function upload(array $data)
	{	
		$data_array = $this->reArrayFiles($data);		
		$upload = new Upload($this->filePath);

		for ($i=0; $i < count($data_array); $i++) {
			if($data_array[$i]['error'] === 1){
				$result[] = 'The uploaded file exceeds the upload_max_filesize in php.ini!';
			}

			if($data_array[$i]['error'] === 2){
				$result[] = 'The uploaded file exceeds the MAX_FILE_SIZE!';
			}

			if($data_array[$i]['error'] === 0){
				if($this->checkImageType($data_array[$i])){
					$data_result = $upload->handle($data_array[$i]);
					$result[] = $this->resize($data_result);
				}
			}
		}
		
		return $result;
	}

	/**
	 * Resizing the image
	 * Thumbnail|Mobile|Desktop	
	 *
	 * @param array $data
	 * @return array
	 *
	 */
	public function resize(array $data)
	{
		//thumbnail
		$thumbnailController = new ThumbnailImageSize($data);
		$thumbnail = $thumbnailController->action();
		
		//mobile
		$mobileController = new MobileImageSize($data);
		$mobile = $mobileController->action();

		//desktop
		$desktopController = new DesktopImageSize($data);
		$desktop = $desktopController->action();

		$data = [
			'thumbnail' => $thumbnail,
			'mobile'	=> $mobile,
			'desktop'	=> $desktop
		];

		return $data;
	}

	/**
	 * Re-arrange the array	
	 *
	 * @param array $data
	 * @return array
	 *
	 */
	public function reArrayFiles(&$data_array)
	{
		if(!is_array($data_array['name'])){
			return $data = array($data_array);
		}

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

	/**
	 * Validate image
	 *
	 * @param array $data
	 * @return boolean
	 *
	 */
	public function checkImageType($data)
	{
		$allowed_ext = [
			'jpeg',
			'jpg',
			'png',
			'gif'
		];

		// Get image file extension
    	$file_extension = strtolower(pathinfo($data['name'], PATHINFO_EXTENSION));

    	// Validate file input to check if is with valid extension
		if(!in_array($file_extension, $allowed_ext)){
			throw new Exception('Upload valid image. Only JPEG, PNG and GIF are allowed!');
		}

		return TRUE;
	}
}
