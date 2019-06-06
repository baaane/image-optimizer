<?php

namespace Library\Baaane\ImageUploader\Action;

use Library\Baaane\ImageUploader\Traits\ImageTrait;
use Library\Baaane\ImageUploader\Contracts\ImageActionInterface;

class DesktopImageSize implements ImageActionInterface
{
	use ImageTrait;

	/**
     * @param array $data
     */
	public function __construct($data)
	{
		$this->data = $data;
		$this->name = $data['name'];
		$this->tmp_name = $data['tmp_name'];
		$this->path = $data['path'];
	}

	/**
     * Execute creating size
     *
     * @return array $data
     */
	public function action()
	{
		$image_info = $this->getImageInfo($this->data);
		$new_image = $this->createSize($image_info);
		$final_image = $this->path.'desktop_'.$this->name;
		$data = $this->createImage($new_image, $this->tmp_name, $final_image);

		// Destroy resources
		imagedestroy($image_info);
		imagedestroy($new_image);
		
		return $data;
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
		imagecopyresampled($new, $image, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);

		return $new;
	}
}