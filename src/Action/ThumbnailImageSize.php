<?php

namespace Library\Baaane\ImageUploader\Action;

use Library\Baaane\ImageUploader\Action\BaseAction;

class ThumbnailImageSize extends BaseAction
{	
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
		$data = $this->create($this->data, $image, '300x300', BaseAction::THUMBNAIL);
		return $data;
	}
}