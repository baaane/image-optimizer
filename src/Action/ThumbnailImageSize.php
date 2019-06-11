<?php

namespace Library\Baaane\ImageUploader\Action;

use Library\Baaane\ImageUploader\Traits\ImageTrait;
use Library\Baaane\ImageUploader\Action\BaseAction;

class ThumbnailImageSize extends BaseAction
{
	use ImageTrait;
	
	/**
     * @param array $data
     */
	public function __construct($data)
	{
		$this->data = $data;
	}

	/**
     * get new size
     *
     * @return string $data
     */
	public function get($image = [])
	{
		$imageSizes = explode(',', $mobile);

		$image 	= $this->getImageInfo($this->data); //get image info
		$new 	= $this->create($width, $height, $image); //create new size
		$final 	= $this->data['path'].BaseAction::THUMBNAIL.$this->data['name']; //final image name

		$data 	= $this->createImage($new, $this->data['tmp_name'], $final);

		// Destroy resources
		imagedestroy($image);
		imagedestroy($new);

		return $data;
	}
}