<?php

namespace Library\Baaane\ImageUploader\Domains;

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
	 * @param string $name
	 * @param string $final
	 * @return string
	 *
	 */
	public function create($new, $name, $final)
	{
		imagegif($new, $final);
		$data = rtrim($final);
		return $data;
	}
}