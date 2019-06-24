<?php

namespace Baaane\ImageUploader\Action;

use Baaane\ImageUploader\Traits\ImageTrait;

abstract class BaseAction
{
	use ImageTrait;

	/**
     * Constant variable 
     */
	const THUMBNAIL = 'thumbnail';
	const MOBILE 	= 'mobile';
	const DESKTOP 	= 'desktop';

	/**
     * Creating new size
     *
	 * @param array $data
	 * @param array $size 
	 * @param array $defaultSize
	 * @param string $name
     *
     * @return array $data
     */
	public function create($data, $size, $defaultSize, $name)
	{
		// Get image info
		$image 	= $this->getImageInfo($data['tmp_name']);

		//Set and get final width and height
		$size = $this->setSize($size, $defaultSize, $name);
		$max_width 	= $size['width'];
		$max_height = $size['height'];

		// Calculate new dimensions
		$old_width  = imagesx($image);
		$old_height = imagesy($image);
		$scale      = min($max_width/$old_width, $max_height/$old_height);
		$new_width  = ceil($scale*$old_width);
		$new_height = ceil($scale*$old_height);

		// Create new empty image
		$new = imagecreatetruecolor($new_width, $new_height);
		imagealphablending( $new, false );
		imagesavealpha( $new, true );

		// Resample old into new
		imagecopyresampled($new, $image, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);

		// Final image
		$final 	= $data['path'].$name.'_'.$data['name'];

		// Create final image
		$data 	= $this->createImage($new, $data['tmp_name'], $final);

		return $data;
	}

	/**
	 * Set final size
	 * Check if width or height is zero 
	 *
	 * @param array $size 
	 * @param array $defaultSize
	 * @param string $name
	 *
	 * @return array
	 */
	public function setSize($size, $defaultSize, $name)
	{
		if(!isset($size['new_size'][$name])){
			return $size = $this->getDefaultSize();
		}

		foreach ($size['new_size'][$name] as $key => $value) {		
			if($value === 0 || $value >= $this->getDefaultSize()[$key]){
				$value = $this->getDefaultSize()[$key];
			}
			$size['new_size'][$key] = $value;
		}
		
		return $size['new_size'];
	}

	/**
	 * Set default size
	 * @param int $width
	 * @param int $height
	 *
	 * @return array
	 */
	public function setDefaultSize($width, $height)
	{
		$data = [
			'width' => $width, 
			'height' => $height
		];

		$this->default_size = $data;
	}

	/**
	 * Get default size
	 *
	 * @return array
	 */
	public function getDefaultSize()
	{
		return $this->default_size;
	}	
}