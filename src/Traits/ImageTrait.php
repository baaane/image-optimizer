<?php

namespace Library\Baaane\ImageUploader\Traits;

use Library\Baaane\ImageUploader\Traits\ImageJpeg;
use Library\Baaane\ImageUploader\Traits\ImagePng;
use Library\Baaane\ImageUploader\Traits\ImageGif;

trait ImageTrait
{
	protected $imageTypes = [
		'image/jpeg' 	=> ImageJpeg::class,
		'image/png' 	=> ImagePng::class,
		'image/gif' 	=> ImageGif::class,
	];

	private function build($type)
	{
		try {		
			$reflection = new \ReflectionClass($this->imageTypes[$type]);
			$class = $reflection->newInstanceArgs([]);
			return $class;
		} catch (Exception $e) {
			throw new \Exception("Image type class not found!");
		}
	}

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
			$image 	= $this->build($type);
			$data 	= $image->info($tmp_name);

			return $data;
		} catch (InvalidImageTypeException $e) {
			throw InvalidImageTypeException::checkMimeType($type);
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
			$image 	= $this->build($type);
			$data 	= $image->create($new, $name, $final);
			
			return $data;
		} catch (InvalidImageTypeException $e) {
				throw InvalidImageTypeException::checkMimeType($type);
		}
	}
}