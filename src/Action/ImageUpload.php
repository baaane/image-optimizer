<?php

namespace Library\ImageUploader;

use Library\ImageUploader\UploadController;
use Library\ImageUploader\ImageActionInterface;
use Library\ImageUploader\ThumbnailImageController;
use Library\ImageUploader\MobileImageController;
use Library\ImageUploader\DesktopImageController;
use Spatie\ImageOptimizer\OptimizerChainFactory;

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
	public function upload($name = NULL)
	{
		$upload = new UploadController($this->filePath);
		$data = $upload->handle($name);
		
		return $this->resize($data);
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
		$path = $data['path'];
        $image_name = $data['name'];
        $tmp_name = $data['tmp_name'];

		$image_info = $this->getImageInfo($data);

		//thumbnail
		$thumbnailController = new ThumbnailImageController($image_info);
		$new_image = $thumbnailController->action();
		$thumbnail = $this->createImage($new_image, $tmp_name, $path.'thumbnail_'.$image_name);
		
		//mobile
		$mobileController = new MobileImageController($image_info);
		$new_image = $mobileController->action();
		$mobile = $this->createImage($new_image, $tmp_name, $path.'mobile_'.$image_name);

		//desktop
		$desktopController = new DesktopImageController($image_info);
		$new_image = $desktopController->action();
		$desktop = $this->createImage($new_image, $tmp_name, $path.'desktop_'.$image_name);

		$data = [
			'thumbnail' => $thumbnail,
			'mobile'	=> $mobile,
			'deskctop'	=> $desktop
		];

		return $data;
	}

	/**
	 * Get the image information
	 * Thumbnail|Mobile|Desktop	 
	 *
	 * @param array $data
	 * @return array $data
	 *
	 */
	public function getImageInfo($data)
	{
		$type = mime_content_type($data['tmp_name']);
		switch(strtolower($type))
		{
	        case 'image/jpeg':
	                $data = imagecreatefromjpeg($data['tmp_name']);
	                break;
	        case 'image/png':
	                $data = imagecreatefrompng($data['tmp_name']);
	                break;
	        case 'image/gif':
	                $data = imagecreatefromgif($data['tmp_name']);
	                break;
	        default:
	                exit('Unsupported type: '.$data['tmp_name']);
		}
		return $data;
	}
	
	/**
	 * Creating new image according to different size 
	 * Thumbnail|Mobile|Desktop
	 *
	 * @param array $data
	 * @return array $data
	 *
	 */
	public function createImage($new, $name, $final)
	{
		$type = mime_content_type($name);
		switch(strtolower($type))
		{
	        case 'image/jpeg':
	                imagejpeg($new, $final);
	                $this->image_optimization($final);
	                $data = rtrim($final);
	                break;
	        case 'image/png':
	                imagepng($new, $final);
	                $this->image_optimization($final);
	                $data = rtrim($final);
	                break;
	        case 'image/gif':
	                imagegif($new, $final);
	                $this->image_optimization($final);
	                $data = rtrim($final);
	                break;
	        default:
	                exit('Unsupported type: '.$type);
		}

		return $data;
	}

	/**
     * Optimize the file
     *
     * @param string $filename with path
     */
	public function image_optimization($filename)
	{
		$optimizerChain = OptimizerChainFactory::create();
		$optimizerChain->optimize($filename);
	}
}