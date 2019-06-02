<?php

namespace Library\ImageUploader;

use Library\ImageUploader\ImageActionInterface;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class DesktopImageController implements ImageActionInterface
{
	/**
     * @param array $data
     */
	public function __construct($data)
	{
		$this->data = $data;
	}

	/**
     * Execute creating size
     *
     * @return array $data
     */
	public function action()
	{
		return $this->createSize($this->data);
	}

	/**
     * Creating new size
     *
     * @return array $data
     */
	public function createSize($image)
	{
		$max_width = 1920;
		$max_height = 1080;

		// Calculate new dimensions
		$old_width      = imagesx($image);
		$old_height     = imagesy($image);
		$scale          = min($max_width/$old_width, $max_height/$old_height);
		$new_width      = ceil($scale*$old_width);
		$new_height     = ceil($scale*$old_height);

		// Create new empty image
		$new = imagecreatetruecolor($new_width, $new_height);

		// Resample old into new
		imagecopyresampled($new, $image, 
		        0, 0, 0, 0, 
		        $new_width, $new_height, $old_width, $old_height);

		return $new;
	}
}