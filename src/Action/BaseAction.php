<?php

namespace Library\Baaane\ImageUploader\Action;

use Spatie\ImageOptimizer\OptimizerChainFactory;
use Library\Baaane\ImageUploader\Traits\ImageTrait;

abstract class BaseAction
{
	use ImageTrait;

	const THUMBNAIL = 'thumbnail';
	const MOBILE 	= 'mobile';
	const DESKTOP 	= 'desktop';

	/**
     * Creating new size
     *
     * @return array $data
     */
	public function create($data, $imageData, $defaultSize, $name)
	{
		// Customize size
		$imageData	= ((isset($imageData[$name])) && (!empty($imageData[$name])) ? $imageData[$name] : $defaultSize);
		$imageSizes = explode('x', $imageData);
		
		// Default size
		$defaultSize = explode('x', $defaultSize);

		// Check if data is not zero
		$max_width 	= ($imageSizes[0] != 0 ? $imageSizes[0] : $defaultSize[0]);
		$max_height = ($imageSizes[1] != 0 ? $imageSizes[1] : $defaultSize[1]);

		// Get image info
		$image 	= $this->getImageInfo($data['tmp_name']);

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

		// Final image
		$final 	= $data['path'].$name.'_'.$data['name'];

		// Create final image
		$data = $this->createImage($new, $data['tmp_name'], $final);

		$this->image_optimization($final);
		return $data;
	}

	/**
     * Optimize the file
     *
     * @param string $filename with path
     */
	private function image_optimization($filename)
	{
		$optimizerChain = OptimizerChainFactory::create();
		$optimizerChain->optimize($filename);
	}
}