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
	 * @param string $name
	 * @param string $final
	 * @return string
	 *
	 */
	public function create($new, $name, $final)
	{
		imagepng($new, $final);
		$data = rtrim($final);
		return $data;
	}
}