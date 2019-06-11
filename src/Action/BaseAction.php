<?php

namespace Library\Baaane\ImageUploader\Action;

abstract class BaseAction
{
	const THUMBNAIL = 'thumbnail_';
	const MOBILE_SIZE = 'mobile_';
	const DESKTOP_SIZE = 'desktop_';

	/**
     * Creating new size
     *
     * @param array $image
     */
	public function create($max_width, $max_height, $image)
	{
		// Calculate new dimensions
		$old_width      = imagesx($image);
		$old_height     = imagesy($image);
		$scale          = min($max_width/$old_width, $max_height/$old_height);
		$new_width      = ceil($scale*$old_width);
		$new_height     = ceil($scale*$old_height);

		// Create new empty image
		$data = imagecreatetruecolor($new_width, $new_height);

		// Resample old into new
		imagecopyresampled($data, $image, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);

		return $data;
	}
}