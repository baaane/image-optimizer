<?php

namespace Baaane\ImageUploader\Traits;

use Baaane\ImageUploader\Domains\ImageJpeg;
use Baaane\ImageUploader\Domains\ImagePng;
use Baaane\ImageUploader\Domains\ImageGif;
use Baaane\ImageUploader\Builder\ReflectionClassBuilder;

trait ImageTrait
{
	private $imageTypes = [
		'image/jpeg' 	=> ImageJpeg::class,
		'image/png' 	=> ImagePng::class,
		'image/gif' 	=> ImageGif::class,
	];

	/**
	 * Get the image information
	 * Thumbnail|Mobile|Desktop	 
	 *
	 * @param array $data
	 * @return array
	 *
	 */
	public function getImageInfo($tmp_name)
	{
		try {
			$type 	= mime_content_type($tmp_name);
			$image 	= ReflectionClassBuilder::create($this->imageTypes[$type]);
			$data 	= $image->info($tmp_name);

			return $data;
		} catch (\Exception $e) {
			// silent continously
		}
	}
	
	/**
	 * Creating new image
	 * Thumbnail|Mobile|Desktop
	 *
	 * @param string $new
	 * @param string $name
	 * @param string $final
	 * @return array
	 *
	 */
	public function createImage($new, $name, $final)
	{
		try {
			$type 	= mime_content_type($name);
			$image 	= ReflectionClassBuilder::create($this->imageTypes[$type]);
			$data 	= $image->create($new, $final);
			
			return $data;
		} catch (\Exception $e) {
			// silent continously
		}

	}
}