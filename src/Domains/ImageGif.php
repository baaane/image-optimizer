<?php

namespace Baaane\ImageUploader\Domains;

class ImageGif
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
		$data = imagecreatefromgif($tmp_name);
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
		$new_image = imagecreatetruecolor($new['new_width'], $new['new_height']);

		// Resample old into new
		imagecopyresampled($new_image, $new['image'], 0, 0, 0, 0, $new['new_width'], $new['new_height'], $new['old_width'], $new['old_height']);

		imagegif($new_image, $final, 100);
		$data = rtrim($final);
		
		return $data;
	}
}