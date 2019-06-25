<?php

namespace Baaane\ImageUploader\Traits;

use Baaane\ImageUploader\Domains\ImageJpeg;
use Baaane\ImageUploader\Domains\ImagePng;
use Baaane\ImageUploader\Domains\ImageGif;
use Baaane\ImageUploader\Builder\ReflectionClassBuilder;

trait ImageTrait
{
	/**
	 * Different class sizes
	 *
	 * @var array $imageTypes
	 *
	 */
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
	public function getImageInfo($filepath)
	{
		try {
			$type 	= mime_content_type($filepath);
			$image 	= ReflectionClassBuilder::create($this->imageTypes[$type]);
			$data 	= $image->info($filepath);

			return $data;
		} catch (\Exception $e) {
			// silent continously
		}
	}
	
	/**
	 * Creating new image
	 * Thumbnail|Mobile|Desktop
	 *
	 * @param string $img
	 * @param string $filepath
	 * @param string $final
	 * @return array
	 *
	 */
	public function createImage($img, $filepath, $final)
	{
		try {
			$type 	= mime_content_type($filepath);
			$image 	= ReflectionClassBuilder::create($this->imageTypes[$type]);
			$data 	= $image->create($img, $final);
			
			return $data;
		} catch (\Exception $e) {
			// silent continously
		}

	}
}