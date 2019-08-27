<?php

namespace Baaane\ImageOptimizer\Action;

use Baaane\ImageOptimizer\Traits\ImageTrait;

abstract class BaseAction
{
	use ImageTrait;

	/**
     * @var string $name 
     */
	protected $name;

	/**
     * @var string $width 
     */
	protected $width;

	/**
     * @var string $height 
     */
	protected $height;

	/**
     * Get new size
     *
     * @return string
     */
	public function get($data, $size = [])
	{
		$data_result = $this->create($data, $size);
		return $data_result;
	}

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
	public function create($data, $size)
	{
		// Get image info
		$image 	= $this->getImageInfo($data['filepath']);

		//Set and get final width and height
		$defaultSize = $this->setDefaultSize($this->width, $this->height);
		$size = $this->setSize($size, $defaultSize, $this->name);
		$max_width 	= $size['width'];
		$max_height = $size['height'];

		// Calculate new dimensions
		$old_width  = imagesx($image);
		$old_height = imagesy($image);
		$scale      = min($max_width/$old_width, $max_height/$old_height);
		$new_width  = ceil($scale*$old_width);
		$new_height = ceil($scale*$old_height);

		$img = [
			'new_width' => $new_width,
			'new_height' => $new_height,
			'old_width'	=> $old_width,
			'old_height' => $old_height,
			'image' => $image
		];

		// Final image
		$final 	= $data['path'].$this->name.'_'.$data['name'];

		// Create final image
		$data 	= $this->createImage($img, $data['filepath'], $final);

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