<?php

namespace Library\ImageUploader;

use Spatie\ImageOptimizer\OptimizerChainFactory;

trait ImageTrait
{
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
	        	throw new Exception('Unsupported type: '.$type);
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
	            throw new Exception('Unsupported type: '.$type);
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