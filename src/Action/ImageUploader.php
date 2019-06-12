<?php

namespace Library\Baaane\ImageUploader\Action;

use Exception;
use Library\Baaane\ImageUploader\Core\Upload;
use Library\Baaane\ImageUploader\Action\MobileImageSize;
use Library\Baaane\ImageUploader\Action\DesktopImageSize;
use Library\Baaane\ImageUploader\Action\ThumbnailImageSize;
use Library\Baaane\ImageUploader\Exceptions\ImageUploaderException;
use Library\Baaane\ImageUploader\Exceptions\InvalidImageTypeException;

class ImageUploader
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
	 * Upload the image
	 *
	 * @param array $data
	 * @return array
	 *
	 */
	public function upload(array $data)
	{		
		try {
			if($data['error'] === 1){
				throw ImageUploaderException::maxFileSize();
			}

			if($data['error'] === 2){
				throw ImageUploaderException::uploadMaxFilezize();
			}

			if($data['error'] === 4){
				throw ImageUploaderException::noFileWasUploaded();
			}

			if($this->checkImageType($data)){
				$upload = new Upload($this->filePath);
				$fileData = $upload->handle($data);
				$result = $this->resize($fileData, $data);

				return $result;
			}

		} catch (ImageUploaderException $e) {
			throw $e;
		}
	}

	/**
	 * Resizing the image
	 * Thumbnail|Mobile|Desktop	
	 *
	 * @param array $data
	 * @return array
	 *
	 */
	public function resize($fileData, $data)
	{
		unset($data['name'],$data['type'],$data['size'],$data['error'],$data['tmp_name']);

		//thumbnail
		// $thumbnailSize = new ThumbnailImageSize($fileData);
		// $thumbnail = $thumbnailSize->get($data);

		// //mobile
		// $mobileSize = new MobileImageSize($fileData);
		// $mobile = $mobileSize->get($data);

		//desktop
		$desktopSize = new DesktopImageSize($fileData);
		$desktop = $desktopSize->get($data);

		$result = [
			// 'thumbnail' => $thumbnail,
			// 'mobile'	=> $mobile,
			'desktop'	=> $desktop
		];

		return $result;	
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
		$data = [];
        foreach($data_array as $key => $value){
            foreach($value as $vkey => $vvalue){
                $data[$vkey][$key] = $vvalue;
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
			'image/jpeg',
			'image/png',
			'image/gif'
		];

		// Get image file extension
    	$file_mime = mime_content_type($data['tmp_name']);

    	// Validate file input to check if is with valid extension
		if(!in_array($file_mime, $allowed_ext)){
			throw InvalidImageTypeException::checkMimeType($file_mime);
		}

		return TRUE;
	}
}
