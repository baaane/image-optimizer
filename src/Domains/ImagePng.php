<?php

namespace Baaane\ImageUploader\Domains;

class ImagePng
{
	/**
	 * Get the image information 
	 *
	 * @param string $tmp_name
	 * @return object
	 *
	 */
	public function info($tmp_name)
	{
		$data = imagecreatefrompng($tmp_name);
		return $data;
	}

	/**
	 * Create new image
	 *
	 * @param string $new
	 * @param string $final
	 * @return string
	 *
	 */
	public function create($new, $final)
	{
		// Create new empty image
		$new_image = imagecreate($new['new_width'], $new['new_height']);

		// Resample old into new
		imagecopyresampled($new_image, $new['image'], 0, 0, 0, 0, $new['new_width'], $new['new_height'], $new['old_width'], $new['old_height']);

		imagepng($new_image, $final);
		$data = rtrim($final);
		
		return $data;
	}
}